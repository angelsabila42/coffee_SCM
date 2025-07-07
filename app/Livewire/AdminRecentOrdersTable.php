<?php

namespace App\Livewire;

use App\Models\IncomingOrder;
use Livewire\Component;
use App\Services\ActivityLogger;
use Livewire\Attributes\On;

class AdminRecentOrdersTable extends BaseIncomingOrderTable
{
//     public function delete(IncomingOrder $incomingOrder){

//         ActivityLogger::log(
//         title: "Deleted an $incomingOrder->orderID",
//         type: 'delete'
//        );
       
//     $incomingOrder-> delete();
    
//    }

     #[On('deleteConfirmed')]
    public function confirmDelete($id){

        $order= IncomingOrder::findOrFail($id);

        ActivityLogger::log(
        title: "Deleted $order->orderID",
        type: 'delete'
       );

        $order->delete();

        session()->flash('success','Record Deleted');

        return redirect()->route('home');
       // $this->dispatch('show-toast', message: 'Record Deleted');   
}

   public function getModelName(){
    return IncomingOrder::class;
   }

    public function render()
    {
        return view('livewire.admin-recent-orders-table',[
            'orders'=> IncomingOrder::latest()->take(5)->get()
        ]);
    }
}
