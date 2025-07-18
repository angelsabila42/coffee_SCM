<?php

namespace App\Livewire;

use App\Models\ImporterModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PesaPalTransaction;
use Illuminate\Support\Facades\Auth;

class ImporterTransactions extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url]
    public $tab = 'payments';

    #[Url]
    public $search = '';

    #[Url]
    public $paymentMethod = '';

    public function updating($property)
    {
        if (in_array($property, ['tab', 'search', 'paymentMethod'])) {
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
        $this->paymentMethod = '';
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
                ->paginate(10);
        }

        // Fetch payments from pesapal_transactions table
        return PesaPalTransaction::with('importer')
            ->where('importer_id', $importerId)
            ->when($this->search, function($query) {
                $query->where('pesapal_merchant_reference', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->when($this->paymentMethod, fn($q) => $q->where('payment_method', $this->paymentMethod))
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {

        
        return view('livewire.importer-transactions', [
            'records' => $this->records
        ]);
    }
}
