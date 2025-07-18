@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">Add New Driver</h2>
        <a href="{{ route('transporter.drivers') }}" class="btn" style="background-color: #A0522D; color: white; border-radius: 20px;">
            <i class="bx bx-arrow-back"></i> Back to Drivers
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-user-plus"></i> Driver Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transporter.drivers.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" style="color: #8B4513; font-weight: 600;">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required
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
                                           id="email" name="email" value="{{ old('email') }}" required
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}" 
                                           placeholder="e.g., +256701234567">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="license_number">Driving License Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                                           id="license_number" name="license_number" value="{{ old('license_number') }}" 
                                           required placeholder="e.g., DL123456789">
                                    @error('license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_number">Vehicle Registration Number</label>
                                    <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror" 
                                           id="vehicle_number" name="vehicle_number" value="{{ old('vehicle_number') }}" 
                                           placeholder="e.g., UBE 123A"
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('vehicle_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address') }}" 
                                           placeholder="Driver's address"
                                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transporter Company Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="transporter_company" style="color: #8B4513; font-weight: 600;">Transporter Company <span class="text-danger">*</span></label>
                                    <select class="form-control @error('transporter_company') is-invalid @enderror" 
                                            id="transporter_company" name="transporter_company" required
                                            style="border: 2px solid #F5F5DC; border-radius: 8px;">
                                        <option value="">Select Transporter Company</option>
                                        @foreach($transporters as $transporter)
                                            <option value="{{ $transporter->co_name }}" 
                                                    data-id="{{ $transporter->id }}"
                                                    {{ old('transporter_company') == $transporter->co_name ? 'selected' : '' }}>
                                                {{ $transporter->co_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="transporter_company_id" name="transporter_company_id" value="{{ old('transporter_company_id') }}">
                                    @error('transporter_company')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('transporter_company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="experience">Years of Experience</label>
                            <select class="form-control" id="experience" name="experience">
                                <option value="">Select experience level</option>
                                <option value="0-1" {{ old('experience') == '0-1' ? 'selected' : '' }}>0-1 years</option>
                                <option value="2-5" {{ old('experience') == '2-5' ? 'selected' : '' }}>2-5 years</option>
                                <option value="5-10" {{ old('experience') == '5-10' ? 'selected' : '' }}>5-10 years</option>
                                <option value="10+" {{ old('experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                            </select>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bx bx-info-circle"></i>
                            <strong>Note:</strong> A default password "password123" will be assigned to this driver. 
                            They can change it after first login.
                        </div>
                        
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary mr-2" onclick="window.history.back()">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Save Driver
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const transporterSelect = document.getElementById('transporter_company');
    const transporterIdInput = document.getElementById('transporter_company_id');
    
    transporterSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            transporterIdInput.value = selectedOption.getAttribute('data-id');
        } else {
            transporterIdInput.value = '';
        }
    });
    
    // Set initial value if there's an old value
    if (transporterSelect.value) {
        const selectedOption = transporterSelect.options[transporterSelect.selectedIndex];
        transporterIdInput.value = selectedOption.getAttribute('data-id');
    }
});
</script>
@endsection
