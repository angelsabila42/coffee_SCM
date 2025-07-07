<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\inventory;
use App\Models\Notification;
use App\Models\OutgoingOrder;

class VendorOrderDetails extends Component
{
    public $order;
    public function mount($orderId){
        $this->order = OutgoingOrder::findOrFail($orderId);
    }
    public function acceptOrder(){
        //update status
        $this->order->status = 'confirmed';
        $this->order->save();

        // change admin view status to pending
        $this->order->status = 'pending';
        $this->order->save();

        //notify admin    
    }
    public function declineOrder()
    {
     $this->order->status = 'declined';
     $this->order->save();
     
     //send a notification to admin
    }
    public function confirmDipatch()
    {
        $this->order->status = 'dispatched';
        $this->order->save();

        //send a notification to admin
       
    }
    public function render()
    {
        return view('livewire.vendor-order-details');
    }
}
