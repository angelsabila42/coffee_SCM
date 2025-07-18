@extends('layouts.app')

@section('page-title', 'Add Driver')

@section('content')
<div class="container mt-4">
    <h2>Add New Driver</h2>
    <form method="POST" action="{{ route('drivers.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
        </div>
        <div class="form-group mt-2">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
        </div>
        <div class="form-group mt-2">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="form-group mt-2">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
        </div>
        
        <!-- Transporter Company Section -->
        <div class="form-group mt-2">
            <label for="transporter_company">Transporter Company <span class="text-danger">*</span></label>
            <select class="form-control" id="transporter_company" name="transporter_company" required>
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
        </div>
        
        <!-- Driver-specific fields -->
        <div class="form-group mt-2">
            <label for="license_number">License Number</label>
            <input type="text" class="form-control" id="license_number" name="license_number" value="{{ old('license_number') }}">
        </div>
        <div class="form-group mt-2">
            <label for="vehicle_number">Vehicle Number</label>
            <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" value="{{ old('vehicle_number') }}">
        </div>
        <div class="form-group mt-2">
            <label for="experience">Experience (years)</label>
            <input type="number" class="form-control" id="experience" name="experience" value="{{ old('experience') }}" min="0">
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Save Driver</button>
        <a href="{{ route('drivers.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>

<script>
document.getElementById('transporter_company').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const transporterId = selectedOption.getAttribute('data-id');
    document.getElementById('transporter_company_id').value = transporterId || '';
});
</script>
@endsection