<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\Helper;
use App\Models\IncomingOrder;
use Livewire\Attributes\Rule;
use App\Models\User;
use App\Notifications\NewIncomingOrderNotification;

class ImporterCreateOrderModal extends Component
{

     public $status, $orderID;
     public $importer_model_id = 1;

    #[Rule('required|numeric|min:20')]    
    public $quantity;

    #[Rule('required|date')]
    public $deadline;

    #[Rule( 'required|string')]
    public $coffeeType;

    #[Rule( 'required|string')]
    public $destination;

    #[Rule( 'required|string')]
    public $grade;
    
       public function mount(){
       $this->orderID= Helper::generateID(IncomingOrder::class,'orderID','IX',5);

    }
    
       public function save(){

        $this->validate();

        $order = IncomingOrder::create([
            'orderID'=> $this->orderID,
            'coffeeType'=>$this->coffeeType,
            'grade' => $this->grade,
            'quantity'=>$this->quantity,
            'destination' =>$this->destination,
            'status'=> 'Requested',
            'deadline'=> $this->deadline,
            'importer_model_id' => $this->importer_model_id
        ]);
            // Notify admin(s)
    $admin = \App\Models\User::where('name', 'Admin')->first();
    if ($admin) {
        $admin->notify(new NewIncomingOrderNotification($order));
    }


        $this->reset(['quantity','coffeeType', 'status', 'deadline', 'destination', 'grade']);
        $this->dispatch('reset-alpine-dropdown');

       $this->orderID= Helper::generateID(IncomingOrder::class,'orderID','IX',5);

        session()->flash('success','Order Sent!');

        $this->redirect('/importer-home/orders');

    }
    public function render()
    {
        return view('livewire.importer-create-order-modal');
    }
}
