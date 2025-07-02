@extends('layouts.app')

@section('page-title', 'Driver Details')

@section('content')
<div class="container mt-4">
    <h2>Driver Details</h2>
    <div class="card">
        <div class="card-body">
            <h4>{{ $driver->name }}</h4>
            <p><strong>Email:</strong> {{ $driver->email }}</p>
            <p><strong>Phone:</strong> {{ $driver->phone }}</p>
            <p><strong>Address:</strong> {{ $driver->address }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-primary btn-sm">Edit</a>
            <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
</div>
@endsection
