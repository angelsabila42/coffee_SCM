<?php

namespace App\Livewire;
use App\Models\OutgoingOrder;



class OutgoingOrderTable extends BaseOutgoingOrderTable
{
    public function getPageName(){
    return 'outgoing-orders';
   }
   public function getModelName(){
    return OutgoingOrder::class;
   }

   public function render()
    {        
        return view('livewire.outgoing-order-table',[
   
            'orders' => $this->filter()
        
        ]);
    }
}