@extends('layouts.app')

@section('page-title', 'Payment Receipt #' . $payment->receipt_number)

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Payment Receipt</h4>
            </div>
            <div class="col-md-6 text-right">
                <h5>Receipt# {{ $payment->receipt_number }}</h5>
                <p>{{ \Carbon\Carbon::parse($payment->date_paid)->format('Y-m-d') }}</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>{{ $payment->payer }}</strong></p>
                {{-- Assuming additional payer details (e.g., P.O Box, City, Country) might be available from a related model or directly on Payment model if needed --}}
                @if($payment->recipient_name)
                    <p><strong>Bill To</strong></p>
                    <p>{{ $payment->recipient_name }}</p>
                    {{-- Assuming additional recipient details might be here --}}
                @endif
            </div>
        </div>

        <h5 class="mt-4">PAYMENT FOR</h5>
        <p>Invoice# {{ $payment->invoice->invoice_number ?? 'N/A' }}</p>
        <p>Amount Paid: Ugx {{ number_format($payment->amount_paid, 2) }}</p>
        <p>Payment Method: {{ $payment->payment_mode ?? 'Bank Transfer' }}</p>

        @if ($payment->receipt_file_path)
            <div class="mt-4">
                <p>Attached Receipt:</p>
                <a href="{{ asset('storage/' . $payment->receipt_file_path) }}" target="_blank" class="btn btn-info btn-sm">View Receipt</a>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
        <a href="#" class="btn btn-primary">Download</a> {{-- Implement download functionality later --}}
    </div>
</div>
@endsection 