<?php

namespace App\Livewire;

use App\Models\OutgoingOrder;
use App\Models\Vendor;
use App\Services\ActivityLogger;
use Livewire\Attributes\On;

class VendorOrder extends BaseOutgoingOrderTable
{
    public function getPageName(){
    return 'vendor-orders';
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

        return redirect()->route('vendor.orders');
       // $this->dispatch('show-toast', message: 'Record Deleted');   

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
