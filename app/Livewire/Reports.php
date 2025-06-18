<?php

namespace App\Livewire;

use Livewire\Component;

class Reports extends Component
{
    public $activeTab = "Sales";

    public function setActiveTab($tab){
        $this->activeTab = $tab;
    }
    public function render()
    {
        return view('livewire.reports');
    }
}
