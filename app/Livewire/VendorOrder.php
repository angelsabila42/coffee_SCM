<?php

namespace App\Livewire;

use App\Models\OutgoingOrder;
use App\Models\Vendor;
use App\Services\ActivityLogger;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class VendorOrder extends BaseOutgoingOrderTable
{
    public $chartData = [];
    public function mount(){
        $this->vendor = Auth::user()?->vendor;
        if($this->vendor){
            $this->chartData = OutgoingOrder::where('vendor_id', $this->vendor->id)
                 ->orderBy('created_at')
                 ->get()
                 ->map(function ($order){
                    return[
                        'x' => $order->created_at->format('Y-m-d'),
                        'y' => $order->quantity ?? 0,
                    ];
                 })
                 ->toArray();
        }
        $this->dispatchBrowserEvent('vendor-chart-data',[
            'data'=> $this->chartData,
        ]);
    }

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
    //$currentVendor = auth()->id ?? null;

    return $model::where('orderID', 'like', '%' .$this->search. '%')
            
            ->when($this->type !== '', fn($q) => $q->where('coffeeType', '=', $this->type))
            ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
            ->when($this->minQuantity !== '', fn($q) => $q->where('quantity', '>=', $this->minQuantity))
            ->when($this->maxQuantity !== '', fn($q) => $q->where('quantity', '<=', $this->maxQuantity))
            ->when($this->startDate !== '', fn($q) => $q->where('created_at', '>=', $this->startDate))
            ->when($this->endDate !== '', fn($q) => $q->where('created_at', '<=', $this->endDate))
            ->when($this->vendor, fn($q) => $q->where('vendor_id', $this->vendor->id))
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
