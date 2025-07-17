<?php

namespace App\Livewire;

use App\Models\ImporterModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class ImporterTransactions extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url]
    public $tab = 'invoices';

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
         $user = Auth::user();
        $importerId = ImporterModel::where('email', $user->email)->first()->id;
        if ($this->tab === 'invoices') {
            return Invoice::query()
                ->where('importer_id', $importerId)
                ->when($this->search, fn($q) => $q->where('invoice_number', 'like', "%{$this->search}%"))
                ->when($this->status, fn($q) => $q->where('status', $this->status))
                ->paginate(10);
        }

        return Payment::query()
            ->where('importerID', $importerId)
            ->when($this->search, fn($q) => $q->where('payer', 'like', "%{$this->search}%"))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->coffeeType, fn($q) => $q->where('coffee_type', $this->coffeeType))
            ->when($this->paymentMode, fn($q) => $q->where('payment_mode', $this->paymentMode))
            ->paginate(10);
    }

    public function render()
    {

        
        return view('livewire.importer-transactions', [
            'records' => $this->records
        ]);
    }
}
