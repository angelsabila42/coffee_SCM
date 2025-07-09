<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;

class WorkAssignment extends Component
{
    #[Url] public $search = '';
    #[Url] public $minQuantity = '';
    protected function filter(){

    return WorkAssignment::where(function($query){
                $query->whereHas('staff', function($q){
                    $q->where('full_name', 'like', '%' . $this->search . '%');
                })->orWhere('id', 'like', '%' .$this->search. '%');
            })
            // ->when($this->type !== '', fn($q) => $q->where('coffeeType', '=', $this->type))
            // ->when($this->country !== '', fn($q) => $q->where('destination', '=', $this->country))
            // ->when($this->grade !== '', fn($q) => $q->where('grade', '=', $this->grade))
            // ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
            // ->when($this->minQuantity !== '', fn($q) => $q->where('quantity', '>=', $this->minQuantity))
            // ->when($this->maxQuantity !== '', fn($q) => $q->where('quantity', '<=', $this->maxQuantity))
            // ->when($this->startDate !== '', fn($q) => $q->where('created_at', '>=', $this->startDate))
            // ->when($this->endDate !== '', fn($q) => $q->where('created_at', '<=', $this->endDate))
            ->paginate(10, pageName: $this->getPageName());


   }
    public function render()
    {
        return view('livewire.work-assignment');
    }
}
