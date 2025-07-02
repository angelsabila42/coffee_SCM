<?php

namespace App\Livewire;

use App\Models\OutgoingOrder;
use App\Models\Vendor;

class VendorOrder extends BaseOutgoingOrderTable
{
    public function getPageName(){
    return 'vendor-orders';
   }

     protected function filter(){
    $model = $this->getModelName();

    return $model::where('orderID', 'like', '%' .$this->search. '%')
            
            ->when($this->type !== '', fn($q) => $q->where('coffeeType', '=', $this->type))
            ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
            ->when($this->minQuantity !== '', fn($q) => $q->where('quantity', '>=', $this->minQuantity))
            ->when($this->maxQuantity !== '', fn($q) => $q->where('quantity', '<=', $this->maxQuantity))
            ->when($this->startDate !== '', fn($q) => $q->where('created_at', '>=', $this->startDate))
            ->when($this->endDate !== '', fn($q) => $q->where('created_at', '<=', $this->endDate))
            ->paginate(10, pageName: $this->getPageName());


   }
    public function getModelName()
    {
        return OutgoingOrder::class;
    }

    public function render()
    {        
        return view('livewire.vendor-order',[
            'orders' => $this->filter()
        ]);
    }
}
