<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Delivery;
use App\Models\Payment;

class VendorReports extends Component
{
    public $activeTab = 'sales';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $sales = Invoice::orderBy('invoice_date', 'desc')->get();
        $deliveries = Delivery::orderBy('date_ordered', 'desc')->get();
        $payments = Payment::orderBy('date_paid', 'desc')->get();
        return view('livewire.vendor-reports', [
            'sales' => $sales,
            'deliveries' => $deliveries,
            'payments' => $payments,
        ]);
    }
} 