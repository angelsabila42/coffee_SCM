<?php

namespace App\Livewire;

use App\Models\IncomingOrder;

class ImporterOrder extends BaseIncomingOrderTable
{
    public function getPageName(){
    return 'importer-orders';
   }

     public function getModelName(){
    return IncomingOrder::class;
   }

   public function render()
    {        
        return view('livewire.importer-order',[
   
            'orders' => $this->filter()
        
        ]);
    }
   
}
