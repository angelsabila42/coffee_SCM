@extends('layouts.app')

@section('page-title', 'Invoice #' . $invoice->invoice_number)

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Invoice</h4>
            </div>
            <div class="col-md-6 text-right">
                <h5>Invoice# {{ $invoice->invoice_number }}</h5>
                <p>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                @if ($invoice->vendor_name)
                    <p><strong>{{ $invoice->vendor_name }}</strong></p>
                    <p>{{ $invoice->vendor_po_box }}</p>
                    <p>{{ $invoice->vendor_city }}, {{ $invoice->vendor_country }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <p><strong>BILL TO</strong></p>
                <p>{{ $invoice->bill_to_name }}</p>
                <p>{{ $invoice->bill_to_po_box }}</p>
                <p>{{ $invoice->bill_to_city }}, {{ $invoice->bill_to_country }}</p>
            </div>
        </div>

        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }} kg</td>
                        <td>{{ $invoice->currency }} {{ number_format($item->unit_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <table class="table table-borderless text-right">
                    <tbody>
                        <tr>
                            <td>Sub total</td>
                            <td>{{ $invoice->currency }} {{ number_format($invoice->sub_total, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <p>Acc No: {{ $invoice->bank_account_no }}</p>
                <p>Bank Name: {{ $invoice->bank_name }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
        <a href="#" class="btn btn-primary">Download</a> {{-- Implement download functionality later --}}
    </div>
</div>
@endsection 