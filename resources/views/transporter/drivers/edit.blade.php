@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">Edit Driver</h2>
        <a href="{{ route('transporter.drivers') }}" class="btn" style="background-color: #A0522D; color: white; border-radius: 20px;">
            <i class="bx bx-arrow-back"></i> Back to Drivers
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-edit"></i> Edit Driver Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transporter.drivers.update', $driver->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" style="color: #8B4513; font-weight: 600;">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $driver->name) }}" required
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" style="color: #8B4513; font-weight: 600;">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $driver->email) }}" required
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" style="color: #8B4513; font-weight: 600;">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $driver->phone) }}" 
                                           placeholder="e.g., +256701234567"
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="license_number" style="color: #8B4513; font-weight: 600;">Driving License Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                                           id="license_number" name="license_number" value="{{ old('license_number', $driver->license_number) }}" 
                                           required placeholder="e.g., DL123456789"
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="vehicle_number" style="color: #8B4513; font-weight: 600;">Vehicle Registration Number</label>
                                    <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror" 
                                           id="vehicle_number" name="vehicle_number" value="{{ old('vehicle_number', $driver->vehicle_number) }}" 
                                           placeholder="e.g., UBE 123A"
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('vehicle_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="address" style="color: #8B4513; font-weight: 600;">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address', $driver->address) }}" 
                                           placeholder="Driver's address"
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="experience" style="color: #8B4513; font-weight: 600;">Years of Experience</label>
                            <select class="form-control" id="experience" name="experience" style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                <option value="">Select experience level</option>
                                <option value="0-1" {{ old('experience', $driver->experience) == '0-1' ? 'selected' : '' }}>0-1 years</option>
                                <option value="2-5" {{ old('experience', $driver->experience) == '2-5' ? 'selected' : '' }}>2-5 years</option>
                                <option value="5-10" {{ old('experience', $driver->experience) == '5-10' ? 'selected' : '' }}>5-10 years</option>
                                <option value="10+" {{ old('experience', $driver->experience) == '10+' ? 'selected' : '' }}>10+ years</option>
                            </select>
                        </div>
                        
                        <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #8B4513; background-color: #F5F5DC;">
                            <i class="bx bx-info-circle" style="color: #8B4513;"></i>
                            <strong style="color: #8B4513;">Note:</strong> <span style="color: #8B4513;">Password changes are not handled here. The driver can change their password from their profile.</span>
                        </div>
                        
                        <div class="form-group text-right">
                            <button type="button" class="btn mr-2" onclick="window.history.back()" style="background-color: #A0522D; color: white; border-radius: 20px;">
                                <i class="bx bx-x"></i> Cancel
                            </button>
                            <button type="submit" class="btn" style="background-color: #8B4513; color: white; border-radius: 20px;">
                                <i class="bx bx-save"></i> Update Driver
                            </button>
                        </div>
                    </form>
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

h2 {
    font-weight: 700;
}

label {
    font-weight: 600;
}

.alert {
    border-radius: 10px;
    border-left: 4px solid #8B4513;
}

.text-muted {
    color: #A0522D !important;
}
</style>
@endsection
