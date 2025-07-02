<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\InvoiceItem;

class VendorTransactionsDashboard extends Component
{
    public $activeTab = 'invoices';
    public $showInvoiceItemsModal = false;
    public $selectedInvoiceItems = [];
    public $selectedInvoiceNumber = '';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function showInvoiceItems($invoiceId)
    {
        $items = InvoiceItem::where('invoice_id', $invoiceId)->get();
        $invoice = Invoice::find($invoiceId);
        $this->selectedInvoiceItems = $items;
        $this->selectedInvoiceNumber = $invoice ? $invoice->invoice_number : '';
        $this->showInvoiceItemsModal = true;
    }

    public function closeInvoiceItemsModal()
    {
        $this->showInvoiceItemsModal = false;
        $this->selectedInvoiceItems = [];
        $this->selectedInvoiceNumber = '';
    }

    public function render()
    {
        $invoices = Invoice::orderBy('invoice_date', 'desc')->get();
        $payments = Payment::orderBy('date_paid', 'desc')->get();
        return view('livewire.vendor-transactions-dashboard', [
            'invoices' => $invoices,
            'payments' => $payments,
        ]);
    }
} 