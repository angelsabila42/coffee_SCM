@extends('layouts.app')

@section('page-title', 'Delivery Report')

@section('sidebar-items')
    @include('layouts.sidebar-items.admin')
@endsection 

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Delivery Report Details</h5>
            @if ($delivery)
                <span class="badge bg-light text-dark">Report ID: {{ $delivery->reportID }}</span>
            @endif
        </div>

        <div class="card-body">
            @if ($delivery)
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">Title:</strong>
                        <div class="text-dark">{{ $delivery->title }}</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">Total Deliveries:</strong>
                        <div class="text-dark">{{ $delivery->total_deliveries }}</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">Start Period:</strong>
                        <div class="text-dark">{{ $delivery->start_period }}</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong class="text-muted">End Period:</strong>
                        <div class="text-dark">{{ $delivery->end_period }}</div>
                    </div>
                </div>

                <div class="border-top pt-3 mt-4">
                    <h6 class="text-primary">Summary Analysis</h6>
                    <p class="text-muted mb-0">
                        This report summarizes coffee delivery performance for the above period.
                        Adjustments and commission calculations can also be included here based on business logic and delivery tracking metrics.
                    </p>
                </div>
            @else
                <div class="alert alert-warning">No delivery report found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
