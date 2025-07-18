<?php

namespace App\Livewire;

use App\Models\IncomingOrder;
use App\Models\OutgoingOrder;
use App\Models\Vendor;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class VendorRecentOrdersTable extends BaseOutgoingOrderTable
{

    public function mount()
    {
        $this->vendor = Auth::user(); 

    }

    public function getModelName()
    {
        return OutgoingOrder::class;
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

        return redirect()->route('vendor.home');
       // $this->dispatch('show-toast', message: 'Record Deleted');   
}

    public function getPageName(){
    return 'vendor-orders';
   }
    public function render()
    {
        
        $orders = $this->getModelName()::where('vendor_id', $this->vendor->id)
                ->latest()
                ->limit(5)
                ->get();
        return view('livewire.vendor-recent-orders-table',[
            'orders'=> $orders
        ]);
    }
}
