<?php

namespace App\Livewire;
use App\Helpers\Helper;
use Livewire\Component;
use App\Models\IncomingOrder;
use App\Models\Notification;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Notifications\OrderDeclinedNotification;
use App\Notifications\OrderAcceptedNotification;
use App\Models\inventory;

class AdminOrderDetails extends Component
{
    public $order;
    public function mount($orderId){
        $this->order = IncomingOrder::findOrFail($orderId);
    }
    public function acceptOrder(){
        //update status
        $this->order->status = 'confirmed';
        $this->order->save();

        //update inventory
        $inventory = inventory::where('coffee_type', $this->order->coffeeType)
        ->where('grade', $this->order->Grade) 
        ->where('quantity','>',0)->orderBy('id', 'asc')
        ->first();

        //check if inventory exists
        if($inventory && $inventory->quantity >= $this->order->quantity){
            $inventory->quantity -= $this->order->quantity;
            $inventory->last_updated = now();
            $inventory->save();
        }
        // change admin view status to pending
        $this->order->status = 'pending';
        $this->order->save();

        //notify importer
        $this->order->importerModel->notify(new OrderAcceptedNotification($this->order));
        
    }
    public function declineOrder()
    {
     $this->order->status = 'declined';
     $this->order->save();
     
     //send a notification
     $this->order->importerModel->notify(new OrderDeclinedNotification($this->order));
     session()->flash('message', 'order declined');
    }
    public function render()
    {
        return view('livewire.admin-order-details');
    }
}
