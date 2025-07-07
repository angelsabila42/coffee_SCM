<?php

namespace App\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\IncomingOrder;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Services\ActivityLogger;


abstract class BaseIncomingOrderTable extends Component
{
     use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $orderID;

    #[Url] public $search = '';
    #[Url] public $type = '';
    #[Url]  public $status = '';
    #[Url] public $minQuantity = '';
    #[Url] public $maxQuantity = '';
    #[Url] public $startDate = '';
    #[Url] public $endDate = '';
    #[Url] public $country = '';
    #[Url] public $grade = '';

  
    protected $updatesQueryString = ['search', 'type', 'status', 'minQuantity', 'maxQuantity', 'startDate', 'endDate', 'country', 'grade'];
    abstract protected function getModelName();
    public function mount(){
        
        $this->status = $this->status ?? '';
        $this->type = $this->type ?? '';
        $this->endDate = $this->endDate ?? '';
        $this->startDate = $this->startDate ?? '';
        $this->search = $this->search ?? '';
        $this->minQuantity = $this->minQuantity ?? '';
        $this->maxQuantity = $this->maxQuantity  ?? '';
        $this->country = $this->country  ?? '';
        $this->grade = $this->grade  ?? '';

        $this->orderID= Helper::generateID(IncomingOrder::class,'orderID','IX',5);
    }

    public function getCountriesProperty(){
        return IncomingOrder::select('destination')
        ->distinct()
        ->orderBy('destination')
        ->get();
    }

    public function getGradesProperty(){
        return IncomingOrder::select('grade')
        ->distinct()
        ->orderBy('grade')
        ->get();
    }

      #[On('statusChanged')]
   public function updateStatus($id, $status){
    $order= IncomingOrder::findOrFail($id);
    $oldStatus = $order->status;
    $order->status = $status;
    $order->save();

    ActivityLogger::log(
        title: "Changed status from $oldStatus to $status for order $order->orderID",
        type: 'update'
       );

   }

      #[On('deleteConfirmed')]
    public function confirmDelete($id){

        $order= IncomingOrder::findOrFail($id);

        ActivityLogger::log(
        title: "Deleted $order->orderID",
        type: 'delete'
       );

        $order->delete();

        session()->flash('success','Record Deleted');

        return redirect()->route('order.index');
       // $this->dispatch('show-toast', message: 'Record Deleted');   
}
   

    public function getPageName(){
    return 'incoming-orders';
   }

   protected function filter(){
    $model = $this->getModelName();

    return IncomingOrder::where(function($query){
                $query->whereHas('importerModel', function($q){
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('orderID', 'like', '%' .$this->search. '%');
            })
            ->when($this->type !== '', fn($q) => $q->where('coffeeType', '=', $this->type))
            ->when($this->country !== '', fn($q) => $q->where('destination', '=', $this->country))
            ->when($this->grade !== '', fn($q) => $q->where('grade', '=', $this->grade))
            ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
            ->when($this->minQuantity !== '', fn($q) => $q->where('quantity', '>=', $this->minQuantity))
            ->when($this->maxQuantity !== '', fn($q) => $q->where('quantity', '<=', $this->maxQuantity))
            ->when($this->startDate !== '', fn($q) => $q->where('created_at', '>=', $this->startDate))
            ->when($this->endDate !== '', fn($q) => $q->where('created_at', '<=', $this->endDate))
            ->paginate(10, pageName: $this->getPageName());


   }

       public function updating($name){
    if(in_array($name,['search','type', 'status', 'minQuantity', 'maxQuantity', 'startDate', 'endDate','country', 'grade'])){
        $this->resetPage($this->getPageName());
    }
   }


    public function clearFilter(){
    $this->status = '';
        $this->type = '';
        $this->endDate = '';
        $this->startDate = '';
        $this->search = '';
        $this->minQuantity = '';
        $this->maxQuantity = '';
        $this->country = '';
        $this->grade = '';


         $this->resetPage($this->getPageName());
   }
}
