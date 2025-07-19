<?php

namespace App\Livewire;
use App\Models\OutgoingOrder;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;


class OutgoingOrderTable extends BaseOutgoingOrderTable
{
    public function getPageName(){
    return 'outgoing-orders';
   }
   public function getModelName(){
    return OutgoingOrder::class;
   }

   #[On('vendorOrderStatusUpdated')]
public function refreshOrders()
{
    Log::info('Admin orders refreshed after vendor status update');
    $this->resetPage();
}

   public function render()
    {        
        return view('livewire.outgoing-order-table',[
   
            'orders' => $this->filter()
        
        ]);
    }
}