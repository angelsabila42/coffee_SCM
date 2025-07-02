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

    public $statusFilter = 'Active';

    public function mount()
    {
        $this->refreshData();
        // $this->driverList = User::where('role', 'driver')->pluck('name', 'id')->toArray();
        $this->driverList = []; // Avoid querying non-existent 'role' column
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
        $this->refreshDriverList();
    }

    public function assignDriver()
    {
        $delivery = Delivery::find($this->selectedDeliveryId);
        if ($delivery) {
            $driverName = $this->selectedDriver ? $this->driverList[$this->selectedDriver] : $this->manualDriverName;
            $delivery->assigned_driver = $driverName;
            $delivery->eta = $this->eta;
            $delivery->save();
            $this->showAssignDriverModal = false;
            $this->refreshData();
        }
    }

    public function closeAssignDriverModal()
    {
        $this->showAssignDriverModal = false;
    }

    public function markCompleted($id)
    {
        $delivery = Delivery::find($id);
        if ($delivery) {
            $delivery->status = 'Completed';
            $delivery->save();
            $this->refreshData();
        }
    }

    public function setStatusFilter($status)
    {
        $this->statusFilter = $status;
        $this->refreshData();
    }

    public function downloadFilteredCsv()
    {
        $deliveries = Delivery::where('status', $this->statusFilter)->get();
        $filename = strtolower($this->statusFilter) . '_deliveries.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        return response()->stream(function () use ($deliveries) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Delivery ID', 'Coffee Type', 'Quantity', 'Pickup', 'Status', 'ETA', 'Date Ordered', 'Assigned Driver']);
            foreach ($deliveries as $delivery) {
                fputcsv($handle, [
                    $delivery->delivery_id,
                    $delivery->coffee_type,
                    $delivery->quantity,
                    $delivery->pickup_location,
                    $delivery->status,
                    $delivery->eta,
                    $delivery->date_ordered,
                    $delivery->assigned_driver,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function goToAddDriver()
    {
        return redirect()->route('drivers.create');
    }

    public function goToViewDelivery($id)
    {
        return redirect()->route('deliveries.show', $id);
    }

    public function render()
    {
        $deliveries = Delivery::where('status', $this->statusFilter)->get();
        $this->activeDeliveries = Delivery::where('status', 'Active')->count();
        $this->pendingDeliveries = Delivery::where('status', 'Pending')->count();
        $this->completedDeliveries = Delivery::where('status', 'Completed')->count();
        $this->delayedDeliveries = Delivery::where('status', 'Delayed')->count();
        $this->currentDeliveries = $deliveries;
        $this->deliveryRequests = Delivery::where('status', 'Requested')->get();
        return view('livewire.transporter-delivery-dashboard');
    }
}