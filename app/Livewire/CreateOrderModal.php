<?php

namespace App\Livewire;

use Doctrine\Inflector\Rules\English\Rules;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Helpers\Helper;
use App\Models\OutgoingOrder;

use App\Notifications\NewOutgoingOrderNotification;
use App\Models\User;

use App\Services\ActivityLogger;


class CreateOrderModal extends Component
{
    public $status, $orderID;

    #[Rule('required|numeric|min:20')]    
    public $quantity;

    #[Rule('required|exists:vendor,id')]
    public  $vendor_id;

    #[Rule('required|exists:work_centers,id')]
    public $work_center_id;

    #[Rule('required|date')]
    public $deadline;

    #[Rule( 'required|string')]
    public $coffeeType;
    
       public function mount(){
        $this->orderID= Helper::generateID(OutgoingOrder::class,'orderID','OX',5);

    }
    
       public function save(){

        $this->validate();

       $order = OutgoingOrder::create([
            'work_center_id'=>$this->work_center_id,
            'vendor_id'=>$this->vendor_id,
            'orderID'=> $this->orderID,
            'coffeeType'=>$this->coffeeType,
            'quantity'=>$this->quantity,
            'status'=> 'Requested',
            'deadline'=> $this->deadline
        ]);
        // $vendor = User::find($order->vendor_id);
        // $vendor->notify(new NewOutgoingOrderNotification($order));
        $admin = \App\Models\User::where('role', 'admin')->first();
    if ($admin) {
        $admin->notify(new NewOutgoingOrderNotification($order));
    }

        $this->reset(['quantity','coffeeType', 'status', 'deadline', 'vendor_id', 'work_center_id']);
        $this->dispatch('reset-alpine-dropdown');

        $this->orderID = Helper::generateID(OutgoingOrder::class,'orderID','OX',5);

        session()->flash('success','Order Sent!');

        $this->redirect('/home/orders');

        ActivityLogger::log(
            title: 'Created new Order',
            type: 'new-order'
        );

    }
    public function render()
    {
        return view('livewire.create-order-modal');
    }
}
