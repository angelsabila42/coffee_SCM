@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">Transport Companies</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; border-left: 4px solid #8B4513;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); color: white;">
                <div class="card-body text-center">
                    <i class="bx bx-buildings" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
                    <h3 class="mb-1">{{ $totalCompanies }}</h3>
                    <p class="mb-0">Total Companies</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #CD853F 0%, #D2691E 100%); color: white;">
                <div class="card-body text-center">
                    <i class="bx bx-check-circle" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
                    <h3 class="mb-1">{{ $activeCompanies }}</h3>
                    <p class="mb-0">Active Companies</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #DEB887 0%, #BC9A6A 100%); color: white;">
                <div class="card-body text-center">
                    <i class="bx bx-group" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
                    <h3 class="mb-1">{{ $totalDrivers }}</h3>
                    <p class="mb-0">Total Drivers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #F4A460 0%, #D2691E 100%); color: white;">
                <div class="card-body text-center">
                    <i class="bx bx-building" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
                    <h3 class="mb-1">{{ number_format($totalDrivers / max($totalCompanies, 1), 1) }}</h3>
                    <p class="mb-0">Avg Drivers/Company</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies List -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-buildings"></i> All Transport Companies
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead style="background-color: #F5F5DC;">
                        <tr>
                            <th style="color: #8B4513;">Company Name</th>
                            <th style="color: #8B4513;">Contact Person</th>
                            <th style="color: #8B4513;">Email</th>
                            <th style="color: #8B4513;">Phone</th>
                            <th style="color: #8B4513;">Address</th>
                            <th style="color: #8B4513;">Drivers Count</th>
                            <th style="color: #8B4513;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies as $company)
                        <tr>
                            <td><strong style="color: #8B4513;">{{ $company->co_name ?? 'N/A' }}</strong></td>
                            <td>{{ $company->name ?? 'Not provided' }}</td>
                            <td>
                                @if($company->email)
                                    <a href="mailto:{{ $company->email }}" style="color: #8B4513; text-decoration: none;">
                                        {{ $company->email }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                            <td>
                                @if($company->phone_number)
                                    <a href="tel:{{ $company->phone_number }}" style="color: #8B4513; text-decoration: none;">
                                        {{ $company->phone_number }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>
                            <td>{{ $company->address ?? 'Not provided' }}</td>
                            <td>
                                @php
                                    $driverCount = \App\Models\User::where('role', 'driver')->where('transporter_company_id', $company->id)->count();
                                @endphp
                                <span class="badge" style="background-color: #8B4513; color: white;">
                                    {{ $driverCount }} drivers
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('transporter.companies.show', $company->id) }}" class="btn btn-primary btn-sm" style="border-radius: 15px; background-color: #8B4513; border-color: #8B4513;">
                                    <i class="bx bx-show"></i> View Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="py-4">
                                    <i class="bx bx-buildings" style="font-size: 3rem; color: #DDD; margin-bottom: 10px;"></i>
                                    <p class="text-muted">No transport companies found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($companies->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $companies->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.badge {
    font-size: 0.85rem;
    padding: 0.5rem 0.75rem;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.alert {
    border-left: 4px solid #8B4513;
}

.text-muted {
    color: #A0522D !important;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.pagination .page-link {
    color: #8B4513;
}

.pagination .page-item.active .page-link {
    background-color: #8B4513;
    border-color: #8B4513;
}
</style>
@endsection
