@extends('layouts.app')
@section('content')
@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">Vendor QA reports</h2>
                <a onclick="window.history.back()" class="btn btn-primary">Back</a>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">                
                    <!-- Report Header -->
                    <div class="report-header mb-5">
                        <div class="row align-items-center">
  <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ReportID</th>
                            <th>Date Created</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr onclick="window.location='{{ route('qa.vendor.report', $record->id) }}'" style="cursor: pointer;">
                            <td>{{ $report->reportID }}</td>
                            <td>{{ $report->date ? $report->date->format('Y-m-d') : 'N/A' }}</td>
                            <td> {{ $report->status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No QA reports found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $reports->links() }}
                </div>
            </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <span class="badge-lg  text-white px-4 py-2 rounded-pill">
                                    4
                                </span>
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
