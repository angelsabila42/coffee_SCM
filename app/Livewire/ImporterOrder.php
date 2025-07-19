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

   protected function filter(){
    $model = $this->getModelName();

    return IncomingOrder::where(function($query){
                $query->whereHas('importerModel', function($q){
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('orderID', 'like', '%' .$this->search. '%');
            })
            ->when($this->type !== '', fn($q) => $q->where('coffeeType', '=', $this->type))
            ->when($this->country !== '', fn($q) => $q->where('destination', '=', $this->country))
            ->when($this->grade !== '', fn($q) => $q->where('grade', '=', $this->grade))
            ->when($this->status !== '', fn($q) => $q->where( 'status', '=', $this->status))
            ->when($this->minQuantity !== '', fn($q) => $q->where('quantity', '>=', $this->minQuantity))
            ->when($this->maxQuantity !== '', fn($q) => $q->where('quantity', '<=', $this->maxQuantity))
            ->when($this->startDate !== '', fn($q) => $q->where('created_at', '>=', $this->startDate))
            ->when($this->endDate !== '', fn($q) => $q->where('created_at', '<=', $this->endDate))
            ->when($this->importer, fn($q) => $q->where('importer_model_id', $this->importer->id))
            ->paginate(10, pageName: $this->getPageName());


   }


   public function render()
    {        
        return view('livewire.importer-order',[
   
            'orders' => $this->filter()
        
        ]);
    }
   
}
