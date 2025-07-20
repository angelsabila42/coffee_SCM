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
use Illuminate\Support\Facades\Auth;

class AdminOrderDetails extends Component
{
    public $order;
    public function mount($orderId){
        $this->order = IncomingOrder::findOrFail($orderId);
    }
    public function acceptOrder(){
        //update status
        $oldStatus = $this->order->status;
        $this->order->status = 'Confirmed';
        $this->order->save();
        $this->order->refresh();

        session()->flash('success','Order Accepted');

        \App\Models\OrderStatusLogger::create([
        'user_id'=> Auth::id(),
        'loggable_id'=>$this->order->id,
        'loggable_type'=> get_class($this->order),
        'action'=> "Status changed from {$oldStatus} to {$this->order->status}"
    ]);

        $this->redirect('/admin-home/orders');

        //update inventory
        $inventory = inventory::where('coffee_type', $this->order->coffeeType)
        ->where('grade', $this->order->grade) 
        ->where('quantity','>',0)->orderBy('id', 'asc')
        ->first();

        //check if inventory exists
        if($inventory && $inventory->quantity >= $this->order->quantity){
            $inventory->quantity -= $this->order->quantity;
            $inventory->last_updated = now();
            $inventory->save();
        }
        // // change admin view status to pending
        // $this->order->status = 'pending';
        // $this->order->save();

        //notify importer
if ($this->order->importerModel) {
    $this->order->importerModel->notify(new OrderAcceptedNotification($this->order));
}

    }
    public function declineOrder()
    {
    $oldStatus = $this->order->status;
     $this->order->status = 'Declined';
     $this->order->save();
    $this->order->refresh();

     \App\Models\OrderStatusLogger::create([
        'user_id'=> Auth::id(),
        'loggable_id'=>$this->order->id,
        'loggable_type'=> get_class($this->order),
        'action'=> "Status changed from {$oldStatus} to {$this->order->status}"
    ]);
     
     // Notify the importer about the declined order
     if ($this->order->importerModel) {
    $this->order->importerModel->notify(new OrderDeclinedNotification($this->order));
}

    }
    public function render()
    {
        $this->order->refresh(); 
        return view('livewire.admin-order-details');
    }
}
