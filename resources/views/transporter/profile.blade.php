@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
<div class="container-fluid">
    <h2 class="mb-4" style="color: #8B4513; font-weight: 700;">Transporter Profile</h2>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-8">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-building"></i> Company Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transporter.profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" style="color: #8B4513; font-weight: 600;">Contact Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ $transporter->name ?? 'Not set' }}" required 
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="co_name" style="color: #8B4513; font-weight: 600;">Company Name</label>
                                    <input type="text" class="form-control" id="co_name" name="co_name" 
                                           value="{{ $transporter->co_name ?? 'Not set' }}" required
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" style="color: #8B4513; font-weight: 600;">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ $transporter->email ?? 'Not set' }}" required
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" 
                                           value="{{ $transporter->phone_number ?? 'Not set' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ $transporter->address ?? 'Not set' }}</textarea>
                        </div>
                        
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Banking Information -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Banking Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transporter.banking.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" 
                                   value="{{ $transporter->Bank_name ?? 'Not set' }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="account_holder">Account Holder Name</label>
                            <input type="text" class="form-control" id="account_holder" name="account_holder" 
                                   value="{{ $transporter->Account_holder ?? 'Not set' }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="bank_account">Account Number</label>
                            <input type="text" class="form-control" id="bank_account" name="bank_account" 
                                   value="{{ $transporter->Bank_account ?? 'Not set' }}">
                        </div>
                        
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Update Banking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Account Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Deliveries:</span>
                        <strong>{{ $totalDeliveries ?? 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Completed Deliveries:</span>
                        <strong>{{ $completedDeliveries ?? 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Active Drivers:</span>
                        <strong>{{ $activeDrivers ?? 0 }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Member Since:</span>
                        <strong>{{ $transporter->created_at ? $transporter->created_at->format('M Y') : 'Unknown' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.form-control {
    transition: border-color 0.2s;
}

.form-control:focus {
    border-color: #8B4513 !important;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25) !important;
}

.btn {
    border-radius: 20px;
    transition: all 0.2s;
}

.btn:hover {
    transform: scale(1.05);
}

.stats-card {
    background: linear-gradient(135deg, #F5F5DC, #DDBF94);
    border-left: 4px solid #8B4513;
}

h2 {
    font-weight: 700;
}

label {
    font-weight: 600;
}
</style>
@endsection
