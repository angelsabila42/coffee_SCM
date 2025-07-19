@extends('layouts.app')

@section('page-title', 'Sales Report')

@section('sidebar-items')
    @include('layouts.sidebar-items.admin')
@endsection 

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sales Report Details</h5>
            @if ($sale)
                <span class="badge bg-light text-dark">Report ID: {{ $sale->reportID }}</span>
            @endif
        </div>

        <div class="card-body">
            @if ($sale)
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">Title:</strong>
                        <div class="text-dark">{{ $sale->title }}</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">Total Sales:</strong>
                        <div class="text-dark">{{ number_format($sale->total_sales, 2) }} USD</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">Start Period:</strong>
                        <div class="text-dark">{{ $sale->start_period }}</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">End Period:</strong>
                        <div class="text-dark">{{ $sale->end_period }}</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">Total Quantity:</strong>
                        <div class="text-dark">{{ $sale->total_quantity }} kg</div>
                    </div>
                </div>

                <div class="border-top pt-3 mt-4">
                    <h6 class="text-success">Summary Analysis</h6>
                    <p class="text-muted mb-0">
                        This report summarizes the coffee sales performance during the specified period.
                        Adjustments and commission calculations based on sales targets, revenue streams, and market fluctuations may be added.
                    </p>
                </div>
            @else
                <div class="alert alert-warning">No sales report found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
