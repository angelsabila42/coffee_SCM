<?php

namespace App\Livewire;

use Doctrine\Inflector\Rules\English\Rules;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Helpers\Helper;
use App\Models\OutgoingOrder;

class CreateOrderModal extends Component
{
    public $status, $orderID;

    #[Rule('required|numeric|min:20')]    
    public $quantity;

    #[Rule('required|exists:vendor,id')]
    public  $vendor_id;

    #[Rule('required|exists:work_centers,id')]
    public $work_center_id;

    #[Rule('required|date')]
    public $deadline;

    #[Rule( 'required|string')]
    public $coffeeType;
    
     public function mount(){
        $this->orderID= Helper::generateID(OutgoingOrder::class,'orderID',5,'OX');

    }
    
       public function save(){

        $this->validate();

        OutgoingOrder::create([
            'work_center_id'=>$this->work_center_id,
            'vendor_id'=>$this->vendor_id,
            'orderID'=> $this->orderID,
            'coffeeType'=>$this->coffeeType,
            'quantity'=>$this->quantity,
            'status'=> 'Requested',
            'deadline'=> $this->deadline
        ]);

        $this->reset(['quantity','coffeeType', 'status', 'deadline', 'vendor_id', 'work_center_id']);
        $this->dispatch('reset-alpine-dropdown');

        $this->orderID = Helper::generateID(OutgoingOrder::class,'orderID',5,'OX');

        $this->redirect('/home/orders', navigate:true);

    }
    public function render()
    {
        return view('livewire.create-order-modal');
    }
}
