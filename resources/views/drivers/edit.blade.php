@extends('layouts.app')

@section('page-title', 'Edit Driver')

@section('content')
<div class="container mt-4">
    <h2>Edit Driver</h2>
    <form method="POST" action="{{ route('drivers.update', $driver->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ Auth::user()->name }}">
        </div>
        <div class="form-group mt-2">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required value="{{ Auth::user()->email }}">
        </div>
        <div class="form-group mt-2">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $driver->phone) }}">
        </div>
        <div class="form-group mt-2">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $driver->address) }}">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Driver</button>
        <a href="{{ route('drivers.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
