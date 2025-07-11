@extends('layouts.app')

@section('page-title', 'Payment Details')

@section('sidebar-item')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-lg" style="max-width: 700px; margin: 0 auto;">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 1.1rem; color: #222;">Payments Receipt</h5>
                </div>
                <div class="text-right">
                    <div class="mb-0" style="font-size: 1rem; color: #222;">Receipt# {{ $payment->receipt_number }}</div>
                    <div style="font-size: 0.95rem; color: #444;">{{ \Carbon\Carbon::parse($payment->date_paid)->format('Y-m-d') }}</div>
                </div>
            </div>
            <hr class="my-3">
            <div class="mb-4" style="line-height: 1.5;">
                <div style="margin-bottom: 1.5rem;">
                    <div style="font-weight: 500;">Elgon Cooperative</div>
                    <div>P.O Box 3263</div>
                    <div>Mbale, Uganda</div>
                </div>
                <div class="mb-2" style="font-weight: 600;">BILL TO</div>
                <div style="margin-bottom: 1.5rem;">
                    <div>GlobalBean Connect Exporters</div>
                    <div>P.O Box 3233</div>
                    <div>Kampala, Uganda</div>
                </div>
                <div class="mb-2" style="font-weight: 600;">PAYMENT FOR</div>
                <div class="mb-1">Invoice# {{ $payment->invoice->invoice_number ?? 'N/A' }}</div>
                <div class="mb-1">Amount Paid: Ugx {{ number_format($payment->amount_paid, 0) }}</div>
                <div class="mb-1">Payment Method: {{ $payment->payment_mode ?? 'Bank Transfer' }}</div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('payments.index') }}" class="btn btn-dark mr-2">Back</a>
                <a href="{{ route('reports.receipt.csv', $payment->id) }}" class="btn btn-secondary">Download</a>
            </div>
        </div>
    </div>
</div>
@endsection 