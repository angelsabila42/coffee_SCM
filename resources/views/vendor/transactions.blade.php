@extends('layouts.app')

@section('page-title', 'Vendor Transactions')
@section('sidebar-items')
    @include('layouts.sidebar-items.vendor')
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">My Transactions</h2>
        <div>
            <button class="btn" onclick="window.location.reload()" style="background-color: #8B4513; color: white; border-radius: 20px;">
                <i class="bx bx-refresh"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #CD853F, #D2691E); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Ugx {{ number_format($totalEarnings ?? 0, 2) }}</h4>
                            <p class="mb-0">Total Earnings</p>
                        </div>
                        <i class="bx bx-dollar-circle" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #8B4513, #A0522D); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $paidInvoices ?? 0 }}</h4>
                            <p class="mb-0">Paid Invoices</p>
                        </div>
                        <i class="bx bx-check-circle" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #A0522D, #CD853F); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $pendingInvoices ?? 0 }}</h4>
                            <p class="mb-0">Pending Invoices</p>
                        </div>
                        <i class="bx bx-clock-alt" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #6B4423, #8B4513); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $totalPayments ?? 0 }}</h4>
                            <p class="mb-0">Total Payments</p>
                        </div>
                        <i class="bx bx-money" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Details -->
    <div class="card mb-4" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-user-circle"></i> Account Details
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background-color: #F5F5DC;">
                        <p class="mb-1 text-muted">Account Holder</p>
                        <h5 class="mb-2" style="color: #8B4513;">
                            {{ $latestInvoice->vendor_name ?? $latestInvoice->bill_to_name ?? Auth::user()->name ?? 'N/A' }}
                        </h5>
                        <p class="mb-1 text-muted">Bank</p>
                        <h6 class="mb-2" style="color: #8B4513;">
                            {{ $latestInvoice->bank_name ?? 'Not Set' }}
                        </h6>
                        <p class="mb-1 text-muted">Account Number</p>
                        <h6 class="mb-0" style="color: #8B4513;">
                            {{ $latestInvoice->bank_account_no ?? 'Not Set' }}
                        </h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background-color: #F5F5DC;">
                        <p class="mb-1 text-muted">Total Earnings</p>
                        <h5 class="mb-2" style="color: #228B22;">Ugx {{ number_format($totalEarnings ?? 0, 2) }}</h5>
                        <p class="mb-1 text-muted">Last Payment</p>
                        <h6 class="mb-0" style="color: #8B4513;">
                            {{ $lastPayment->date_paid ?? 'No payments yet' }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Tables -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-receipt"></i> Transactions & Invoices
            </h5>
        </div>
        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="transactionTabs" role="tablist" style="border-bottom: 2px solid #F5F5DC;">
                <li class="nav-item">
                    <a class="nav-link active" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab" 
                       style="color: #8B4513; font-weight: 600;">
                        <i class="bx bx-file"></i> My Invoices
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab"
                       style="color: #8B4513; font-weight: 600;">
                        <i class="bx bx-money"></i> My Payments
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="transactionTabsContent">
                <!-- Invoices Tab -->
                <div class="tab-pane fade show active" id="invoices" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #F5F5DC;">
                                <tr>
                                    <th style="color: #8B4513;">Invoice #</th>
                                    <th style="color: #8B4513;">Date</th>
                                    <th style="color: #8B4513;">Coffee Type</th>
                                    <th style="color: #8B4513;">Amount</th>
                                    <th style="color: #8B4513;">Description</th>
                                    <th style="color: #8B4513;">Status</th>
                                    <th style="color: #8B4513;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices ?? [] as $invoice)
                                    <tr>
                                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
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
                                            <a href="{{ route('invoices.show', $invoice->id) }}" 
                                               class="btn btn-sm" style="background-color: #CD853F; color: white; border-radius: 15px;">
                                                <i class="bx bx-show"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No invoices available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payments Tab -->
                <div class="tab-pane fade" id="payments" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #F5F5DC;">
                                <tr>
                                    <th style="color: #8B4513;">Payment #</th>
                                    <th style="color: #8B4513;">Date</th>
                                    <th style="color: #8B4513;">Coffee Type</th>
                                    <th style="color: #8B4513;">Amount</th>
                                    <th style="color: #8B4513;">Description</th>
                                    <th style="color: #8B4513;">Status</th>
                                    <th style="color: #8B4513;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments ?? [] as $payment)
                                    <tr>
                                        <td><strong>{{ $payment->receipt_number }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($payment->date_paid)->format('M d, Y') }}</td>
                                        <td>{{ $payment->coffee_type }}</td>
                                        <td>Ugx {{ number_format($payment->amount_paid, 2) }}</td>
                                        <td>{{ $payment->payment_description }}</td>
                                        <td>
                                            @if ($payment->status == 'Paid')
                                                <span class="badge badge-success">{{ $payment->status }}</span>
                                            @elseif ($payment->status == 'Awaiting')
                                                <span class="badge badge-warning">{{ $payment->status }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $payment->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('payments.show', $payment->id) }}" 
                                               class="btn btn-sm" style="background-color: #CD853F; color: white; border-radius: 15px;">
                                                <i class="bx bx-show"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No payments available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
.card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.table th {
    border-top: none;
    font-weight: 600;
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.8em;
    border-radius: 15px;
}

.btn {
    border-radius: 20px;
    transition: all 0.2s;
    margin-right: 5px;
}

.btn:hover {
    transform: scale(1.05);
}

.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}

h2 {
    font-weight: 700;
}

.nav-tabs .nav-link.active {
    background-color: #F5F5DC;
    border-color: #F5F5DC;
    color: #8B4513 !important;
}

.nav-tabs .nav-link:hover {
    background-color: #F5F5DC;
    border-color: #F5F5DC;
}
</style>
@endsection
@endsection
