@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add New Driver</h2>
    <form method="POST" action="{{ route('drivers.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group mt-2">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group mt-2">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="form-group mt-2">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save Driver</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection 