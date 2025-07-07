<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Helpers\Helper;
use App\Models\OutgoingOrder;
use App\Models\VendorOrderDispatch;

class VendorOrderDispatchModal extends Component
{

    public $status, $orderID, $order;

    #[Rule('required|numeric|min:20')]    
    public $quantity;

    #[Rule('required|exists:work_centers,id')]
    public $work_center_id;

    #[Rule('required|date')]
    public $dateDispatched;

    #[Rule( 'required|string')]
    public $coffeeType;
    
       public function mount($orderID){
        $this->orderID = $orderID;
        $this->order= OutgoingOrder::findOrFail($orderID);
    }
    
       public function save(){

        $this->validate();

        VendorOrderDispatch::create([
            'work_center_id'=>$this->work_center_id,
            'orderID'=> $this->orderID,
            'coffeeType'=>$this->coffeeType,
            'quantity'=>$this->quantity,
            'dateDispatched'=> $this->dateDispatched,
            'outgoing_order_id'=> $this->orderID
        ]);

        $this->reset(['quantity','coffeeType', 'dateDispatched', 'work_center_id']);
        $this->dispatch('reset-alpine-dropdown');

        session()->flash('success','Dispatch Confirmed!');

        $this->redirect('/vendor-home/orders');

    }
    public function render()
    {
        return view('livewire.vendor-order-dispatch-modal');
    }
}
