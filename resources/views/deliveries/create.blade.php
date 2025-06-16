@extends('layouts.app')

@section('page-title', 'Create Delivery Request')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Create New Delivery Request</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('deliveries.store') }}" method="POST">
            @csrf
            @include('deliveries._form')
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('deliveries.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection 