@extends('layouts.app')

@section('page-title', 'Transactions')
@section('sidebar-items')
    @include('layouts.sidebar-items.admin')
@endsection

@section('sidebar-item')
    @include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0 font-weight-bold" style="color:#222">Account Details</h3>
                <!-- Payment Action Buttons -->
                <div class="d-flex gap-3">
                    <a href="{{ route('payments.vendor.form') }}" class="btn btn-brown btn-lg d-flex align-items-center shadow-sm" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); border: none; border-radius: 25px; padding: 10px 20px; color: white; text-decoration: none; transition: all 0.3s ease;">
                        <span class="me-2" style="font-size: 1.1em;">🌱</span>
                        <span class="fw-bold">Pay Vendor</span>
                    </a>
                    
                    <a href="{{ route('payments.transporter.form') }}" class="btn btn-brown btn-lg d-flex align-items-center shadow-sm" style="background: linear-gradient(135deg, #A0522D 0%, #CD853F 100%); border: none; border-radius: 25px; padding: 10px 20px; color: white; text-decoration: none; transition: all 0.3s ease;">
                        <span class="me-2" style="font-size: 1.1em;">🚛</span>
                        <span class="fw-bold">Pay Transporter</span>
                    </a>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1 text-muted">Account Holder</p>
                        <h5 class="mb-2" style="color:#6c757d">
                            {{ $latestInvoice->vendor_name ?? $latestInvoice->bill_to_name ?? 'N/A' }}
                        </h5>
                        <p class="mb-1 text-muted">Bank</p>
                        <h6 class="mb-2" style="color:#6c757d">
                            {{ $latestInvoice->bank_name ?? 'N/A' }}
                        </h6>
                        <p class="mb-1 text-muted">Account Number</p>
                        <h6 class="mb-0" style="color:#6c757d">
                            {{ $latestInvoice->bank_account_no ?? 'N/A' }}
                        </h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1 text-muted">Total Earnings</p>
                        <h5 class="mb-2" style="color:#28a745">Ugx {{ number_format($totalEarnings, 2) }}</h5>
                        <!-- <p class="mb-1 text-muted">Preferences</p>
                        <a href="#" class="text-primary">Edit Preferences</a> -->
                    </div>
                </div>
            </div>

            <h3 class="mt-4 font-weight-bold" style="color:#222">Payments and Billing</h3>
            
            <!-- Tabs -->
            <ul class="nav nav-tabs modern-tabs mb-4" id="paymentTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab" aria-controls="invoices" aria-selected="true" style="color:#6c757d;background:#e5ded7;">Invoices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false" style="color:#6c757d;">Payments</a>
                </li>
            </ul>

            <div class="tab-content" id="paymentTabsContent">
                <!-- Invoices Tab -->
                <div class="tab-pane fade show active" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <div class="form mr-3 position-relative">
                            <span class="position-absolute" style="left:10px;top:8px;color:#aaa;"><i class="nc-icon nc-zoom-split"></i></span>
                            <input type="text" class="form-control pl-4" placeholder="Search" style="width:200px;">
                        </div>
                        <button class="btn btn-light btn-fill btn-sm d-flex align-items-center" style="color:#6c757d;">
                            <span class="mr-2"><i class='bx bx-filter'></i></span>Filter
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead class="bg-light">
                                <tr style="color:#6c757d;">
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Coffee Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</td>
                                        <td>{{ $invoice->coffee_type ?? '-' }}</td>
                                        <td>{{ $invoice->currency ?? 'Ugx' }} {{ number_format($invoice->total, 2) }}</td>
                                        <td>{{ $invoice->description ?? '-' }}</td>
                                        <td>
                                            @if ($invoice->status == 'Paid')
                                                <span class="badge badge-success">{{ $invoice->status }}</span>
                                            @elseif ($invoice->status == 'Awaiting')
                                                <span class="badge badge-warning">{{ $invoice->status }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $invoice->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Payments Tab -->
                <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <div class="form mr-3 position-relative">
                            <span class="position-absolute" style="left:10px;top:8px;color:#aaa;"><i class="nc-icon nc-zoom-split"></i></span>
                            <input type="text" class="form-control pl-4" placeholder="Search" style="width:200px;">
                        </div>
                        <button class="btn btn-light btn-fill btn-sm d-flex align-items-center" style="color:#6c757d;">
                            <span class="mr-2"><i class='bx bx-filter'></i></span>Filter
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead class="bg-light">
                                <tr style="color:#6c757d;">
                                    <th>Payment #</th>
                                    <th>Date</th>
                                    <th>Importer</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->pesapal_merchant_reference }}</td>
                                        <td>
                                            {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') : \Carbon\Carbon::parse($payment->created_at)->format('d M, Y') }}
                                        </td>
                                        <td>{{ $payment->importer->co_name ?? 'N/A' }}</td>
                                        <td>Ugx {{ number_format($payment->total_amount, 2) }}</td>
                                        <td>{{ $payment->payment_method ?? 'PesaPal' }}</td>
                                        <td>
                                            @if ($payment->status == 'COMPLETED')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif ($payment->status == 'PENDING')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($payment->status == 'FAILED')
                                                <span class="badge badge-danger">Failed</span>
                                            @elseif ($payment->status == 'CANCELLED')
                                                <span class="badge badge-secondary">Cancelled</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $payment->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewPesapalTransaction({{ $payment->id }})">View</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix bg-white border-0">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PesaPal Transaction Details Modal -->
<div class="modal fade" id="pesapalTransactionModal" tabindex="-1" role="dialog" aria-labelledby="pesapalTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 10px;">
            <div class="modal-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                <h5 class="modal-title" id="pesapalTransactionModalLabel">
                    <i class="bx bx-credit-card"></i> PesaPal Transaction Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pesapalTransactionDetails" style="background-color: #FAFAFA;">
                <!-- Transaction details will be loaded here -->
            </div>
            <div class="modal-footer" style="background-color: #F5F5DC;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="bx bx-x"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewPesapalTransaction(transactionId) {
    // Show loading in modal
    document.getElementById('pesapalTransactionDetails').innerHTML = '<div class="text-center py-4"><i class="bx bx-loader-alt bx-spin" style="font-size: 2rem; color: #8B4513;"></i><br><span style="color: #8B4513;">Loading transaction details...</span></div>';
    
    // Show modal
    $('#pesapalTransactionModal').modal('show');
    
    // Fetch transaction details
    fetch('/admin/pesapal-transaction/' + transactionId + '/details', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const transaction = data.transaction;
            const orderIds = Array.isArray(transaction.order_ids) ? transaction.order_ids.join(', ') : (transaction.order_ids || 'N/A');
            
            document.getElementById('pesapalTransactionDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 style="color: #8B4513; border-bottom: 2px solid #F5F5DC; padding-bottom: 5px;">Transaction Information</h6>
                        <p><strong>Merchant Reference:</strong> ${transaction.pesapal_merchant_reference || 'N/A'}</p>
                        <p><strong>Tracking ID:</strong> ${transaction.pesapal_tracking_id || 'N/A'}</p>
                        <p><strong>Total Amount:</strong> Ugx ${transaction.total_amount ? parseFloat(transaction.total_amount).toLocaleString() : '0.00'}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge ${transaction.status === 'COMPLETED' ? 'badge-success' : transaction.status === 'PENDING' ? 'badge-warning' : transaction.status === 'FAILED' ? 'badge-danger' : 'badge-secondary'}">${transaction.status || 'N/A'}</span>
                        </p>
                        <p><strong>Payment Method:</strong> ${transaction.payment_method || 'PesaPal'}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 style="color: #8B4513; border-bottom: 2px solid #F5F5DC; padding-bottom: 5px;">Additional Details</h6>
                        <p><strong>Importer:</strong> ${transaction.importer ? transaction.importer.co_name : 'N/A'}</p>
                        <p><strong>Order IDs:</strong> ${orderIds}</p>
                        <p><strong>Description:</strong> ${transaction.description || 'No description'}</p>
                        <p><strong>Payment Date:</strong> ${transaction.payment_date ? new Date(transaction.payment_date).toLocaleDateString() : 'Not set'}</p>
                        <p><strong>Created:</strong> ${transaction.created_at ? new Date(transaction.created_at).toLocaleDateString() : 'N/A'}</p>
                    </div>
                </div>
                ${transaction.pesapal_response ? `
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 style="color: #8B4513; border-bottom: 2px solid #F5F5DC; padding-bottom: 5px;">PesaPal Response</h6>
                        <pre style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; font-size: 12px;">${JSON.stringify(transaction.pesapal_response, null, 2)}</pre>
                    </div>
                </div>
                ` : ''}
            `;
        } else {
            document.getElementById('pesapalTransactionDetails').innerHTML = '<div class="text-center py-4 text-danger">Failed to load transaction details.</div>';
        }
    })
    .catch(error => {
        document.getElementById('pesapalTransactionDetails').innerHTML = '<div class="text-center py-4 text-danger">Error loading transaction details.</div>';
        console.error('Error:', error);
    });
}
</script>

@section('styles')
<style>
.modal-content {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.8em;
    border-radius: 15px;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.btn {
    border-radius: 20px;
    transition: all 0.2s;
}

.btn:hover {
    transform: scale(1.05);
}

/* Payment Button Styles */
.btn-brown:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 8px 25px rgba(139, 69, 19, 0.4) !important;
}

.btn-brown:first-child:hover {
    background: linear-gradient(135deg, #654321 0%, #8B4513 100%) !important;
}

.btn-brown:last-child:hover {
    background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%) !important;
}

.gap-3 {
    gap: 1rem !important;
}

@media (max-width: 768px) {
    .d-flex.gap-3 {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-brown {
        width: 100%;
        margin-bottom: 10px;
        justify-content: center;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .d-flex.justify-content-between .d-flex.gap-3 {
        margin-top: 15px;
        width: 100%;
    }
}

.modal-header {
    border-bottom: 1px solid #F5F5DC;
}

.modal-footer {
    border-top: 1px solid #F5F5DC;
}

h6 {
    font-weight: 600;
}

pre {
    max-height: 200px;
    overflow-y: auto;
}
</style>
@endsection
@endsection