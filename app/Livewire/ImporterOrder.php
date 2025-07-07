<?php

namespace App\Livewire;

use App\Models\IncomingOrder;
use Livewire\Attributes\On;
use App\Services\ActivityLogger;

class ImporterOrder extends BaseIncomingOrderTable
{
    public function getPageName(){
    return 'importer-orders';
   }

     public function getModelName(){
    return IncomingOrder::class;
   }

     #[On('deleteConfirmed')]
    public function confirmDelete($id){

        $order= IncomingOrder::findOrFail($id);

        ActivityLogger::log(
        title: "Deleted $order->orderID",
        type: 'delete'
       );

        $order->delete();

        session()->flash('success','Record Deleted');

        return redirect()->route('importer.orders');
       // $this->dispatch('show-toast', message: 'Record Deleted');   

}


   public function render()
    {        
        return view('livewire.importer-order',[
   
            'orders' => $this->filter()
        
        ]);
    }
   
}
