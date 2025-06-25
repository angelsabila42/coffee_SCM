<?php

namespace App\Livewire;

use App\Helpers\Helper;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\OutgoingOrder;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class OutgoingOrderTable extends Component
{
    use WithPagination;

//#[Url]
//public ?int $page = 1;
     //protected string $paginationTheme = 'bootstrap';

     
   // protected $queryString = ['page'];

    public $orderID;

    public function mount(){
        $this->orderID= Helper::generateID(OutgoingOrder::class,'orderID',5,'OX');

    }

    /*public function delete(OutgoingOrder $outgoingOrder){
    $outgoingOrder-> delete();
   }*/

   #[On('deleteConfirmed')]
   public function confirmDelete($id){
    OutgoingOrder::findOrFail($id)->delete();
    session() ->flash('success', 'Record Deleted');
   }
   
    public function render()
    {
        return view('livewire.outgoing-order-table',[
            'orders'=>OutgoingOrder::paginate(10)
        ]);
    }
}
