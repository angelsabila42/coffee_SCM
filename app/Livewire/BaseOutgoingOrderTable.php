<?php

namespace App\Livewire;

use App\Helpers\Helper;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\OutgoingOrder;
use App\Models\Vendor;
use App\Services\ActivityLogger;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

abstract class BaseOutgoingOrderTable extends Component

{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $orderID ;
    public $vendor;

    #[Url] public $search = '';
    #[Url] public $type = '';
    #[Url]  public $status = '';
    #[Url] public $minQuantity = '';
    #[Url] public $maxQuantity = '';
    #[Url] public $startDate = '';
    #[Url] public $endDate = '';
    #[Url] public $country = '';
    
    protected $updatesQueryString = ['search', 'type', 'status', 'minQuantity', 'maxQuantity', 'startDate', ' endDate'];

    abstract protected function getModelName();
    abstract protected function getPageName();

    public function mount(){
        $this->status = $this->status ?? '';
        $this->type = $this->type ?? '';
        $this->endDate = $this->endDate ?? '';
        $this->startDate = $this->startDate ?? '';
        $this->search = $this->search ?? '';
        $this->minQuantity = $this->minQuantity ?? '';
        $this->maxQuantity = $this->maxQuantity  ?? '';
        $this->country = $this->country  ?? '';
        $this->vendor= Vendor::where('email', Auth::user()->email)->first();
        

        $this->orderID= Helper::generateID(OutgoingOrder::class,'orderID','OX',5);

    }

   #[On('statusChanged')]
   public function updateStatus($id, $status){
    $order= OutgoingOrder::findOrFail($id);
    $oldStatus = $order->status;
    $order->status = $status;
    $order->save();

    ActivityLogger::log(
        title: "Changed status from $oldStatus to $status for order $order->orderID",
        type: 'update'
       );

       \App\Models\OrderStatusLogger::create([
        'user_id'=>Auth::id(),
        'loggable_id'=>$order->id,
        'loggable_type'=> get_class($order),
        'action'=> "Status changed from $oldStatus to $status"
    ]);
   }

   #[On('deleteConfirmed')]
    public function confirmDelete($id){

        $order= OutgoingOrder::findOrFail($id);

        ActivityLogger::log(
        title: "Deleted $order->orderID",
        type: 'delete'
       );

        $order->delete();

        session()->flash('success','Record Deleted');

        return redirect()->route('order.index');
       // $this->dispatch('show-toast', message: 'Record Deleted');   

}
   protected function filter(){
    $model = $this->getModelName();

    return $model::where(function($query){
                $query->whereHas('vendor', function($q){
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('orderID', 'like', '%' .$this->search. '%');
            })
            ->when($this->type !== '', fn($q) => $q->where('coffeeType', '=', $this->type))
            ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
            ->when($this->minQuantity !== '', fn($q) => $q->where('quantity', '>=', $this->minQuantity))
            ->when($this->maxQuantity !== '', fn($q) => $q->where('quantity', '<=', $this->maxQuantity))
            ->when($this->startDate !== '', fn($q) => $q->where('created_at', '>=', $this->startDate))
            ->when($this->endDate !== '', fn($q) => $q->where('created_at', '<=', $this->endDate))
            ->paginate(10, pageName: $this->getPageName());

   }

   public function updating($name){
    if(in_array($name,['search','type', 'status', 'minQuantity', 'maxQuantity', 'startDate', 'endDate'])){
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

         $this->resetPage($this->getPageName());

   }

}
