<?php

namespace App\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use Livewire\WithPagination;

class IncomingOrder extends Component
{
     use WithPagination;

         public $orderID, $quantity,$status, $deadline, $grade, $destination;

    public function mount(){
        $this->orderID= Helper::generateID(IncomingOrder::class,'orderID',5,'OX');

    }

       public function save(){
        IncomingOrder::create([
            'orderID'=> $this->orderID,
            'quantity'=>$this->quantity,
            'status'=> $this->status,
            'deadline'=> $this->deadline,
            'destination'=> $this->destination,
            'grade'=> $this->grade
        ]);

    }

    public function render()
    {
        return view('livewire.incoming-order',[
            'order'=> IncomingOrder::paginate(10)
        ]);
    }
}
