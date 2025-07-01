<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class TransporterDeliveryDashboard extends Component
{
    public $activeDeliveries;
    public $pendingDeliveries;
    public $completedDeliveries;
    public $delayedDeliveries;
    public $currentDeliveries;
    public $deliveryRequests;

    // Modal and assignment properties
    public $showAssignDriverModal = false;
    public $selectedDeliveryId;
    public $driverList = [];
    public $selectedDriver = '';
    public $manualDriverName = '';
    public $eta = '';
    public $sendEmail = false;

    public function mount()
    {
        $this->refreshData();
        $this->driverList = User::where('role', 'driver')->pluck('name', 'id')->toArray();
    }

    public function refreshData()
    {
        $this->activeDeliveries = Delivery::where('status', 'Active')->count();
        $this->pendingDeliveries = Delivery::where('status', 'Pending')->count();
        $this->completedDeliveries = Delivery::where('status', 'Completed')->count();
        $this->delayedDeliveries = Delivery::where('status', 'Delayed')->count();
        $this->currentDeliveries = Delivery::whereIn('status', ['Active', 'Pending'])->get();
        $this->deliveryRequests = Delivery::where('status', 'Requested')->get();
    }

    public function accept($id)
    {
        $delivery = Delivery::find($id);
        if ($delivery) {
            $delivery->status = 'Active';
            $delivery->save();
            // TODO: Send notification to exporter
            $this->refreshData();
        }
    }

    public function decline($id)
    {
        $delivery = Delivery::find($id);
        if ($delivery) {
            $delivery->status = 'Declined';
            $delivery->save();
            $this->refreshData();
        }
    }

    public function downloadSummary($id)
    {
        // TODO: Implement download logic (PDF, etc.)
    }

    public function showAssignDriverModal($id)
    {
        $this->selectedDeliveryId = $id;
        $this->showAssignDriverModal = true;
        $this->selectedDriver = '';
        $this->manualDriverName = '';
        $this->eta = '';
        $this->sendEmail = false;
    }

    public function assignDriver()
    {
        $delivery = Delivery::find($this->selectedDeliveryId);
        if ($delivery) {
            $driverName = $this->selectedDriver ? $this->driverList[$this->selectedDriver] : $this->manualDriverName;
            $delivery->assigned_driver = $driverName;
            $delivery->eta = $this->eta;
            $delivery->save();
            // TODO: Optionally send email confirmation
            $this->showAssignDriverModal = false;
            $this->refreshData();
        }
    }

    public function closeAssignDriverModal()
    {
        $this->showAssignDriverModal = false;
    }

    public function render()
    {
        return view('livewire.transporter-delivery-dashboard');
    }
} 