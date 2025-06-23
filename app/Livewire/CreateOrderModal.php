<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\Helper;
use App\Models\OutgoingOrder;

class CreateOrderModal extends Component
{
    public $orderID, $quantity,$coffeeType, $status, $deadline, $vendor_id, $work_center_id;

     public function mount(){
        $this->orderID= Helper::generateID(OutgoingOrder::class,'orderID',5,'OX');

    }

    
       public function save(){
        OutgoingOrder::create([
            'work_center_id'=>$this->work_center_id,
            'vendor_id'=>$this->vendor_id,
            'orderID'=> $this->orderID,
            'coffeeType'=>$this->coffeeType,
            'quantity'=>$this->quantity,
            'status'=> $this->status,
            'deadline'=> $this->deadline
        ]);

        $this->reset('$quantity','$coffeeType', '$status', '$deadline', '$vendor_id', '$work_center_id');

        $this->orderID = Helper::generateID(OutgoingOrder::class,'orderID',5,'OX');

    }
    public function render()
    {
        return view('livewire.create-order-modal');
    }
}
