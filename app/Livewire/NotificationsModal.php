<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\Helper;
use App\Models\Notification;

class NotificationsModal extends Component
{
     public $message, $NotID, $is_read = 'false';
    public function mount(){
        $this->NotID = Helper::generateID(Notification::class,'NotID',5,'NT');
    }

    public function save(){
        Notification::create([
            'message'=>$this->message,
            'is_read'=>$this->is_read,
            'NotID'=>$this->NotID
        ]);
    }
    public function render()
    {
        return view('livewire.notifications-modal');
    }
}
