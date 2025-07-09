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
            <h3 class="mb-4 font-weight-bold" style="color:#222">Account Details</h3>
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
                                    <th>Coffee Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->receipt_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->date_paid)->format('d M, Y') }}</td>
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
                                            <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-outline-primary">View</a>
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
@endsection