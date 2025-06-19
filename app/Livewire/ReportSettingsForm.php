<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ReportSettings;

class ReportSettingsForm extends Component
{
    public $autogenerateFrequency, $prefferedTime;

    public function save(){
        ReportSettings::create([
        'autogenerateFrequency' => $this->autogenerateFrequency,
        'preferredTime' => $this->prefferedTime,
       ]);

       session()->flash('message','Report settings saved!');

    }
    public function render()
    {
        return view('livewire.report-settings-form');
    }
}
