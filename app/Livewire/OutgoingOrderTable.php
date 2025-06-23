<?php

namespace App\Livewire;

use App\Helpers\Helper;
use Livewire\Component;
use App\Models\OutgoingOrder;
use Livewire\WithPagination;

class OutgoingOrderTable extends Component
{
    use WithPagination;

    public $orderID;

    public function mount(){
        $this->orderID= Helper::generateID(OutgoingOrder::class,'orderID',5,'OX');

    }

    public function delete(OutgoingOrder $outgoingOrder){
    $outgoingOrder-> delete();
   }
    public function render()
    {
        return view('livewire.outgoing-order-table',[
            'orders'=>OutgoingOrder::paginate(10)
        ]);
    }
}
