@extends('layouts.app')

@section('page-title', 'Edit Delivery Request')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Delivery Request: {{ $delivery->delivery_id }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('deliveries.update', $delivery->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}
            @include('deliveries._form', ['delivery' => $delivery])
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('deliveries.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection 