@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">{{ $company->co_name ?? 'Transport Company' }}</h2>
        <a href="{{ route('transporter.companies') }}" class="btn" style="background-color: #A0522D; color: white; border-radius: 20px;">
            <i class="bx bx-arrow-back"></i> Back to Companies
        </a>
    </div>

    <!-- Company Information Card -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-building"></i> Company Information
                    </h5>
                </div>
                <div class="card-body" style="background-color: #FAFAFA;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Company Name:</label>
                                <p class="mb-1">{{ $company->co_name ?? 'Not provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Contact Person:</label>
                                <p class="mb-1">{{ $company->name ?? 'Not provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Email:</label>
                                <p class="mb-1">
                                    @if($company->email)
                                        <a href="mailto:{{ $company->email }}" style="color: #8B4513; text-decoration: none;">
                                            {{ $company->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Phone Number:</label>
                                <p class="mb-1">
                                    @if($company->phone_number)
                                        <a href="tel:{{ $company->phone_number }}" style="color: #8B4513; text-decoration: none;">
                                            {{ $company->phone_number }}
                                        </a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Address:</label>
                                <p class="mb-1">{{ $company->address ?? 'Not provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Registration Date:</label>
                                <p class="mb-1">{{ $company->created_at ? $company->created_at->format('M d, Y') : 'Not available' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Driver Statistics -->
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); color: white;">
                <div class="card-body text-center">
                    <i class="bx bx-group" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <h3 class="mb-2">{{ $driverCount }}</h3>
                    <p class="mb-3">Total Drivers</p>
                    <div class="row">
                        <div class="col-6">
                            <small>Available</small>
                            <h5>{{ $availableDrivers }}</h5>
                        </div>
                        <div class="col-6">
                            <small>On Delivery</small>
                            <h5>{{ $busyDrivers }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banking Information -->
    @if($company->Bank_name || $company->Bank_account || $company->Account_holder)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #CD853F; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-credit-card"></i> Banking Information
                    </h5>
                </div>
                <div class="card-body" style="background-color: #FAFAFA;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Bank Name:</label>
                                <p class="mb-1">{{ $company->Bank_name ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Account Number:</label>
                                <p class="mb-1">{{ $company->Bank_account ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Account Holder:</label>
                                <p class="mb-1">{{ $company->Account_holder ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Company Drivers -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-group"></i> Company Drivers ({{ $driverCount }})
                </h5>
                @if(auth()->user() && auth()->user()->role == 'transporter')
                <a href="{{ route('transporter.drivers.create') }}" class="btn btn-light btn-sm" style="border-radius: 15px;">
                    <i class="bx bx-plus"></i> Add Driver
                </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            @if($companyDrivers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead style="background-color: #F5F5DC;">
                            <tr>
                                <th style="color: #8B4513;">Name</th>
                                <th style="color: #8B4513;">Email</th>
                                <th style="color: #8B4513;">Phone</th>
                                <th style="color: #8B4513;">License Number</th>
                                <th style="color: #8B4513;">Vehicle Number</th>
                                <th style="color: #8B4513;">Experience</th>
                                <th style="color: #8B4513;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companyDrivers as $driver)
                            <tr>
                                <td><strong>{{ $driver->name }}</strong></td>
                                <td>
                                    <a href="mailto:{{ $driver->email }}" style="color: #8B4513; text-decoration: none;">
                                        {{ $driver->email }}
                                    </a>
                                </td>
                                <td>
                                    @if($driver->phone)
                                        <a href="tel:{{ $driver->phone }}" style="color: #8B4513; text-decoration: none;">
                                            {{ $driver->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </td>
                                <td>{{ $driver->license_number ?? 'Not provided' }}</td>
                                <td>{{ $driver->vehicle_number ?? 'Not assigned' }}</td>
                                <td>{{ $driver->experience ? $driver->experience . ' years' : 'Not specified' }}</td>
                                <td>
                                    @if($driver->is_available ?? true)
                                        <span class="badge badge-success">Available</span>
                                    @else
                                        <span class="badge badge-warning">On Delivery</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bx bx-user-x" style="font-size: 3rem; color: #DDD; margin-bottom: 10px;"></i>
                    <p class="text-muted">No drivers assigned to this company yet.</p>
                    @if(auth()->user() && auth()->user()->role == 'transporter')
                    <a href="{{ route('transporter.drivers.create') }}" class="btn" style="background-color: #8B4513; color: white; border-radius: 20px;">
                        <i class="bx bx-plus"></i> Add First Driver
                    </a>
                    @endif
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

.text-muted {
    color: #A0522D !important;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

label {
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

p {
    font-size: 1rem;
    color: #333;
}

.badge-success {
    background-color: #28a745;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}
</style>
@endsection
