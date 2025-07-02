<div class="container py-4">
    <h2 class="mb-4">Vendor Transactions Dashboard</h2>
    <div class="card mb-4">
        <div class="card-header">Account Details</div>
        <div class="card-body">
            @if($invoices->count())
                <div><strong>Vendor Name:</strong> {{ $invoices->first()->vendor_name }}</div>
                <div><strong>Bank Account:</strong> {{ $invoices->first()->bank_account_no }}</div>
                <div><strong>Bank Name:</strong> {{ $invoices->first()->bank_name }}</div>
            @else
                <div>No account details available.</div>
            @endif
        </div>
    </div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'invoices' ? 'active' : '' }}" href="#" wire:click.prevent="setActiveTab('invoices')">Invoices</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'payments' ? 'active' : '' }}" href="#" wire:click.prevent="setActiveTab('payments')">Payments</a>
        </li>
    </ul>
    @if($activeTab === 'invoices')
        <div class="card">
            <div class="card-header">Invoices</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Currency</th>
                            <th>Purpose</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->status }}</td>
                                <td>{{ $invoice->sub_total }}</td>
                                <td>{{ $invoice->total }}</td>
                                <td>{{ $invoice->currency }}</td>
                                <td>{{ $invoice->purpose }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" wire:click="showInvoiceItems({{ $invoice->id }})">View</button>
                                    <a href="{{ route('invoices.exportCsv', $invoice->id) }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($activeTab === 'payments')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Payments</span>
                <a href="{{ route('reports.payment.csv') }}" class="btn btn-success btn-sm">Download CSV</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Receipt #</th>
                            <th>Invoice #</th>
                            <th>Payer</th>
                            <th>Amount Paid</th>
                            <th>Date Paid</th>
                            <th>Payment Mode</th>
                            <th>Status</th>
                            <th>Coffee Type</th>
                            <th>Description</th>
                            <th>Recipient Name</th>
                            <th>Receipt File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->receipt_number }}</td>
                                <td>{{ optional($payment->invoice)->invoice_number }}</td>
                                <td>{{ $payment->payer }}</td>
                                <td>{{ $payment->amount_paid }}</td>
                                <td>{{ $payment->date_paid }}</td>
                                <td>{{ $payment->payment_mode }}</td>
                                <td>{{ $payment->status }}</td>
                                <td>{{ $payment->coffee_type }}</td>
                                <td>{{ $payment->payment_description }}</td>
                                <td>{{ $payment->recipient_name }}</td>
                                <td>
                                    @if($payment->receipt_file_path)
                                        <!-- <a href="{{ asset('storage/' . $payment->receipt_file_path) }}" class="btn btn-sm btn-success" target="_blank">Download</a> -->
                                        <a href="{{ route('reports.receipt.csv', $payment->id) }}" class="btn btn-sm btn-primary ml-1">Download</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@if($showInvoiceItemsModal)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invoice Items for #{{ $selectedInvoiceNumber }}</h5>
                <button type="button" class="close" wire:click="closeInvoiceItemsModal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedInvoiceItems as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->unit_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" wire:click="closeInvoiceItemsModal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif 