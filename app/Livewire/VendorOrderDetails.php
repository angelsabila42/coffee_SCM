<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\inventory;
use App\Models\Notification;
use App\Models\OutgoingOrder;
use App\Notifications\OrderDeclined;
use App\Notifications\OrderAccepted;
use App\Notifications\OrderDispatched;

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
         
    $this->order->vendor->notify(new OrderAccepted($this->order));
    
        // change admin view status to pending
        // $this->order->status = 'pending';
        // $this->order->save();

        //notify admin    
    }
    public function declineOrder()
    {
     $this->order->status = 'declined';
     $this->order->save();
     $this->order->refresh();

      $this->order->vendor->notify(new OrderDeclined($this->order));
     
     //send a notification to admin
    }
    public function confirmDispatch()
    {
        $this->order->status = 'dispatched';
        $this->order->save();

        //send a notification to admin
          $this->order->vendor->notify(new OrderDispatched($this->order));

        //update inventory
        $inventory = inventory::where('coffee_type', $this->order->coffeeType)->first();
        if($inventory){ 
        $inventory->quantity += $this->order->quantity;
         $inventory->last_updated = now();
         $inventory->save();
        }
    }
    public function render()
    {
        return view('livewire.vendor-order-details');
    }
}
