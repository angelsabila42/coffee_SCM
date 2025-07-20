<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\Helper;
use App\Models\IncomingOrder;
use Livewire\Attributes\Rule;
use App\Models\User;
use App\Notifications;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewIncomingOrderNotification;
use Illuminate\Support\Facades\Auth;
 /** @var \App\Models\ImporterModel|null */

class ImporterCreateOrderModal extends Component
{
    public $order;
     public $status, $orderID;

     public $importer;

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
       $this->importer = \App\Models\importerModel::where('email', Auth::user()->email)->first();

    }
    
       public function save(){

        $this->validate();
        if (!$this->importer) {
          session()->flash('error', 'Importer not found. Cannot create order.');
             return;
        }

        $order = IncomingOrder::create([
            'orderID'=> $this->orderID,
            'coffeeType'=>$this->coffeeType,
            'grade' => $this->grade,
            'quantity'=>$this->quantity,
            'destination' =>$this->destination,
            'status'=> 'Requested',
            'deadline'=> $this->deadline,
            'importer_model_id' => $this->importer->id,
        ]);
        
            // Notify admin(s)
    $admins = \App\Models\User::where('role', 'admin')->get();
    if ($admins) {
        Notification::send( $admins, new NewIncomingOrderNotification($order));
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
