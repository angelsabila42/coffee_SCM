<?php

namespace App\Livewire;

use Livewire\Component;

class Orders extends Component
{
    public $activeTab = "Incoming";

    public function setActiveTab($tab){
        $this->activeTab = $tab;
    }
    public function render()
    {
        return view('livewire.orders');
    }
}
