@extends('layouts.app')

@section('page-title', 'Invoice #' . $invoice->invoice_number)

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-lg" style="max-width: 700px; margin: 0 auto;">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 1.1rem; color: #222;">Invoice</h5>
                </div>
                <div class="text-right">
                    <div class="mb-0" style="font-size: 1rem; color: #222;">Invoice# {{ $invoice->invoice_number }}</div>
                    <div style="font-size: 0.95rem; color: #444;">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</div>
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
                <div class="mb-2" style="font-weight: 600;">INVOICE FOR</div>
                <div class="mb-1">Amount: {{ $invoice->currency ?? 'Ugx' }} {{ number_format($invoice->total, 0) }}</div>
                <div class="mb-1">Status: {{ $invoice->status }}</div>
            </div>
            <table class="table table-bordered mb-4" style="margin-top: 2rem;">
                <thead class="bg-dark text-white">
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
                            <td>{{ $invoice->currency ?? 'Ugx' }} {{ number_format($item->unit_price, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-end mt-4">
                <div class="col-md-6">
                    <table class="table table-borderless text-right mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight:600; font-size:1.1rem;">Sub total</td>
                                <td style="font-weight:600; font-size:1.1rem;">{{ $invoice->currency ?? 'Ugx' }} {{ number_format($invoice->sub_total ?? $invoice->total, 0) }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:700; font-size:1.2rem;">Total</td>
                                <td style="font-weight:700; font-size:1.2rem;">{{ $invoice->currency ?? 'Ugx' }} {{ number_format($invoice->total, 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('payments.index') }}" class="btn btn-dark mr-2">Back</a>
                <a href="{{ route('invoices.exportCsv', $invoice->id) }}" class="btn btn-secondary">Download</a>
            </div>
        </div>
    </div>
</div>
@endsection