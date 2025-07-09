<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Inventory extends Component
{
    use WithPagination;
    #[Url] public $search = '';
    #[Url] public $type = '';
    #[Url] public $grade = '';
    #[Url] public $status = '';
    #[Url] public $minQuantity = '';
    #[Url] public $maxQuantity = '';

    protected $updatesQueryString = ['search', 'grade', 'status', 'minQuantity','maxQuantity'];


   public function updating($name){
    if(in_array($name,['search','type', 'status', 'minQuantity', 'maxQuantity'])){
        $this->resetPage();
    }
   }

   public function clearFilter(){
    $this->status = '';
        $this->type = '';
        $this->search = '';
        $this->minQuantity = '';
        $this->maxQuantity = '';
        $this->grade = '';


         $this->resetPage($this->getPageName());
   }

//     public function filter(){
//         logger('Filtering with: ' . $this->search);

//     return \App\Models\inventory::where(function($query){
//                     $query->where('warehouse_name', 'like', '%' . $this->search . '%')
//                           ->orWhere('coffee_type', 'like', '%' .$this->search. '%');
//             })
//             //  ->when($this->type !== '', fn($q) => $q->where('coffee_type', '=', $this->type))
//             // ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
//             // ->when($this->minQuantity !== '', fn($q) => $q->where('quantity', '>=', $this->minQuantity))
//             // ->when($this->maxQuantity !== '', fn($q) => $q->where('quantity', '<=', $this->maxQuantity))
//             // ->when($this->startDate !== '', fn($q) => $q->where('created_at', '>=', $this->startDate))
//             // ->when($this->endDate !== '', fn($q) => $q->where('created_at', '<=', $this->endDate))
//             ->paginate(10, pageName: $this->getPageName());


//    }

    public function getGradesProperty(){
        return \App\Models\inventory::select('grade')
        ->distinct()
        ->orderBy('grade')
        ->get();
    }

    public function render()
    {

             logger('Filtering with: ' . $this->search);

    $inventories = \App\Models\inventory::where(function($query){
                    $query->where('warehouse_name', 'like', '%' . $this->search . '%')
                          ->orWhere('coffee_type', 'like', '%' .$this->search. '%');
            })->when($this->grade !== '', fn($q) => $q->where('grade', '=', $this->grade))
              ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
              ->paginate(10);

        return view('livewire.inventory',compact('inventories'));
    }
}
