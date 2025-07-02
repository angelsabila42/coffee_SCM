<?php

namespace App\Livewire;

use App\Models\IncomingOrder;
use Livewire\Component;

class AdminRecentOrdersTable extends Component
{
    public function delete(IncomingOrder $incomingOrder){
    $incomingOrder-> delete();
   }
    public function render()
    {
        return view('livewire.admin-recent-orders-table',[
            'orders'=> IncomingOrder::latest()->take(5)->get()
        ]);
    }
}
