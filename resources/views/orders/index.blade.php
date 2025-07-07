@extends('layouts.app')

@section('page-title', 'Transactions')

@section('sidebar-item')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Transactions</h4>
        <div class="d-flex align-items-center">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab" aria-controls="invoices" aria-selected="true">Invoices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">Payments</a>
                </li>
            </ul>
            <div class="input-group input-group-sm ml-3" style="width: 150px;">
                <input type="text" name="table_search" class="form-control" placeholder="Search">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm ml-2"><i class="nc-icon nc-simple-add"></i> New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                {{-- Invoices Table --}}
                <div class="table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Order Date</th>
                                <th>Phone Number</th>
                                <th>Recipient</th>
                                <th>Amount</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y:i A') }}</td>
                                    <td>{{ $invoice->recipient_phone }}</td>
                                    <td>{{ $invoice->bill_to_name }}</td>
                                    <td>{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</td>
                                    <td>{{ $invoice->purpose }}</td>
                                    <td>{{ $invoice->status }}</td>
                                    <td>
                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $invoices->links() }} {{-- Pagination links --}}
                </div>
            </div>
            <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                {{-- Payments Table --}}
                <div class="table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Payment #</th>
                                <th>Date</th>
                                <th>Coffee Type</th>
                                <th>Recipient</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->receipt_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->date_paid)->format('d M, Y:i A') }}</td>
                                    <td>{{ $payment->coffee_type }}</td>
                                    <td>{{ $payment->recipient_name }}</td>
                                    <td>Ugx {{ number_format($payment->amount_paid, 2) }}</td>
                                    <td>{{ $payment->payment_description }}</td>
                                    <td>{{ $payment->status }}</td>
                                    <td>
                                        <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $payments->links() }} {{-- Pagination links --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 