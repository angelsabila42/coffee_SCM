<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;

class Inventory extends Component
{

    #[Url] public $search = '';
     #[Url] public $type = '';

    protected $updatesQueryString = ['search'];
    public function filter(){

    return inventory::where(function($query){
                $query->whereHas('', function($q){
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('coffee_type', 'like', '%' .$this->search. '%');
            })
             ->when($this->type !== '', fn($q) => $q->where('coffee_type', '=', $this->type))
            // ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
            // ->when($this->minQuantity !== '', fn($q) => $q->where('quantity', '>=', $this->minQuantity))
            // ->when($this->maxQuantity !== '', fn($q) => $q->where('quantity', '<=', $this->maxQuantity))
            // ->when($this->startDate !== '', fn($q) => $q->where('created_at', '>=', $this->startDate))
            // ->when($this->endDate !== '', fn($q) => $q->where('created_at', '<=', $this->endDate))
            ->paginate(10, pageName: $this->getPageName());


   }
    public function render()
    {
        return view('livewire.inventory');
    }
}
