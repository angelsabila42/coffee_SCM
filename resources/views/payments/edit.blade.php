@extends('layouts.app')

@section('page-title', 'Edit Payment Record #' . $payment->receipt_number)

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Payment Record: {{ $payment->receipt_number }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data"> {{-- Add enctype for file upload --}}
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}
            @include('payments._form', ['payment' => $payment, 'invoices' => $invoices])
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection 