<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transporter;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
class VendorLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url]
    public $tab = '';

    #[Url]
    public $search = '';

    #[Url]
    public $status = '';

    #[Url]
    public $coffeeType = '';

    #[Url]
    public $paymentMode = '';

    public function updating($property)
    {
        if (in_array($property, ['tab', 'search', 'status', 'coffeeType', 'paymentMode'])) {
            $this->resetPage();
        }
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->coffeeType = '';
        $this->paymentMode = '';
        $this->resetPage();
    }

    public function getRecordsProperty()
    {
        $user =Auth::user();
        $vendor = Vendor::where('email', $user->email)->first();
        $vendorid = $vendor ? $vendor->id : null;

        // if ($this->tab === 'invoices') {
        //     return Invoice::query()
        //         ->where('transporter_id', $transporterId)
        //         ->when($this->search, fn($q) => $q->where('invoice_number', 'like', "%{$this->search}%"))
        //         ->when($this->status, fn($q) => $q->where('status', $this->status))
        //         ->paginate(10);
        // }

        return Payment::query()
            ->where('vendor_id', $vendorid)
            ->when($this->search, fn($q) => $q->where('payer', 'like', "%{$this->search}%"))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->coffeeType, fn($q) => $q->where('coffee_type', $this->coffeeType))
            ->when($this->paymentMode, fn($q) => $q->where('payment_mode', $this->paymentMode))
            ->paginate(10);
    }

    public function render()
    {

        
        return view('livewire.vendor-livewire', [
            'records' => $this->records
        ]);
    }
}
