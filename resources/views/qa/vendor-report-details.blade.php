@extends('layouts.app')
@section('content')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">Report  Details</h2>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">                <div class="card-body">
                    <!-- Report Header -->
                    <div class="report-header mb-5">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h3 class="text-primary mb-3">Report Details</h3>
                                <div class="d-flex gap-4">
                                    <div>
                                        <p class="text-muted mb-1">Report ID</p>
                                        <h5 class="fw-bold">{{ $report->reportID }}</h5>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-1">Date</p>
                                        <h5 class="fw-bold">{{ $report->date->format('F d, Y') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <span class="badge-lg {{ $report->status === 'draft' ? 'bg-warning' : 'bg-success' }} text-white px-4 py-2 rounded-pill">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Information -->
                    <div class="sample-info mb-5">
                        <h4 class="section-title border-bottom pb-2 mb-4">Sample Information</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="text-muted">Vendor</label>
                                    <h5 class="fw-bold mb-3">{{ $report->vendor->name }}</h5>
                                </div>
                                <div class="info-group">
                                    <label class="text-muted">Region</label>
                                    <h5 class="fw-bold mb-3">{{ $report->region }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="text-muted">Reference Number</label>
                                    <h5 class="fw-bold mb-3">{{ $report->ref }}</h5>
                                </div>
                                <div class="info-group">
                                    <label class="text-muted">Tester</label>
                                    <h5 class="fw-bold mb-3">{{ $report->testers_initials }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Crop Details -->
                    <div class="crop-details mb-5">
                        <h4 class="section-title border-bottom pb-2 mb-4">Crop Details</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="text-muted">Crop Year</label>
                                    <h5 class="fw-bold mb-3">{{ $report->crop_year }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="text-muted">Screen Description</label>
                                    <h5 class="fw-bold mb-3">{{ $report->screen_description ?? 'N/A' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Color Assessment -->
                    <div class="color-assessment mb-5">
                        <h4 class="section-title border-bottom pb-2 mb-4">Color Assessment</h4>
                        <div class="color-indicator p-3 rounded">
                            <h5 class="fw-bold mb-0">{{ ucfirst(str_replace('-', ' ', $report->color)) }}</h5>
                        </div>
                    </div>

                    <!-- Defect Analysis -->
                    <div class="defect-analysis mb-5">
                        <h4 class="section-title border-bottom pb-2 mb-4">Defect Analysis</h4>
                        <div class="row">
                            @foreach(['category1' => 'Category 1', 'category2' => 'Category 2', 'category3' => 'Category 3'] as $key => $title)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header bg-dark text-white">
                                            {{ $title }} Defects
                                        </div>
                                        <div class="card-body">
                                            @if(isset($report->defects[$key]) && count($report->defects[$key]) > 0)
                                                <ul class="list-group list-group-flush">
                                                    @foreach($report->defects[$key] as $defect => $value)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ ucfirst(str_replace('_', ' ', $defect)) }}
                                                            <span class="badge bg-secondary">{{ $value }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted mb-0">No defects found</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>                    <!-- Final Assessment -->
                    <div class="final-assessment mb-5">
                        <h4 class="section-title border-bottom pb-2 mb-4">Final Assessment</h4>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="assessment-card p-4 rounded">
                                    <label class="text-muted d-block mb-2">Fragrance</label>
                                    <h5 class="fw-bold mb-0">{{ $report->fragrance }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="assessment-card p-4 rounded">
                                    <label class="text-muted d-block mb-2">Moisture Content</label>
                                    <h5 class="fw-bold mb-0">{{ $report->moisture_content }}%</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="assessment-card p-4 rounded">
                                    <label class="text-muted d-block mb-2">Overall Impression</label>
                                    <h5 class="fw-bold mb-0">{{ $report->overall_impression }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>@if($report->status === 'draft')
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('qa.vendor') }}'">Back</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    background: #fff;
    border: none;
}

.card-header {
    border-top-left-radius: 15px !important;
    border-top-right-radius: 15px !important;
    padding: 1rem;
}

.section-title {
    color: #2c3e50;
    font-size: 1.25rem;
}

.badge-lg {
    font-size: 1rem;
    font-weight: 500;
}

.info-group label {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.assessment-card {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.assessment-card:hover {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.color-indicator {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
}

.text-muted {
    color: #6c757d !important;
}

.border-bottom {
    border-color: #e9ecef !important;
}

.rounded {
    border-radius: 0.5rem !important;
}

.rounded-pill {
    border-radius: 50rem !important;
}
</style>
@endsection
