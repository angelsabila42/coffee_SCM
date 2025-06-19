<?php

namespace App\Livewire;

use App\Models\NotificationSetting;
use App\Models\OutgoingOrder;
use Livewire\Component;


class NotificationSettingsForm extends Component
{
    public $email_alerts = 'true';
    public $in_app_alerts = 'true';

    public function save(){
        NotificationSetting::create([
            'email-alerts'=>$this->email_alerts,
            '$in-app-alerts'=>$this->in_app_alerts
        ]);
    }
   
    public function render()
    {
        return view('livewire.notification-settings-form',[
            'order'=> OutgoingOrder::paginate(10)
        ]);
    }
}
