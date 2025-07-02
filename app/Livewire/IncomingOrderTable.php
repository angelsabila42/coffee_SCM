<?php

namespace App\Livewire;

use App\Models\IncomingOrder;

class IncomingOrderTable extends BaseIncomingOrderTable
{

    public function getPageName(){
    return 'incoming-orders';
   }

    public function getModelName(){
    return IncomingOrder::class;
   }

   public function render()
    {        
        return view('livewire.incoming-order-table',[
   
            'orders' => $this->filter()
        
        ]);
    }
}
