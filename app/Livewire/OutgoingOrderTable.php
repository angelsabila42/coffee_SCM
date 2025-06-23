<?php

namespace App\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use App\Models\OutgoingOrder;
use Livewire\WithPagination;

class OutgoingOrderTable extends Component
{
    public $orderID, $quantity,$status, $deadline;

    public function mount(){
        $this->orderID= Helper::generateID(OutgoingOrder::class,'orderID',5,'OX');

    }

       public function save(){
        OutgoingOrder::create([
            'orderID'=> $this->orderID,
            'quantity'=>$this->quantity,
            'status'=> $this->status,
            'deadline'=> $this->deadline
        ]);

    }

    public function delete(OutgoingOrder $outgoingOrder){
    $outgoingOrder-> delete();
   }
    public function render()
    {
        return view('livewire.outgoing-order');
    }
}
