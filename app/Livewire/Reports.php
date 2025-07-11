<?php

namespace App\Livewire;

use Livewire\Component;

class Reports extends Component
{
    public $activeTab = "Sales";

    public function setActiveTab($tab){
        $this->activeTab = $tab;
    }

    public function generateReport()
    {
        if ($this->activeTab === 'Sales') {
            return redirect()->route('reports.sales.csv');
        } elseif ($this->activeTab === 'Delivery') {
            return redirect()->route('reports.delivery.csv');
        } elseif ($this->activeTab === 'QA') {
            // You need to implement this route/controller if not present
            return redirect()->route('reports.qa.csv');
        }
    }

    public function render()
    {
        return view('livewire.reports');
    }
}
