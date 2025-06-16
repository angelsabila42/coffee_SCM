@extends('layouts.app')

@section('page-title', 'Edit Invoice #' . $invoice->invoice_number)

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Invoice: {{ $invoice->invoice_number }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}
            @include('invoices._form', ['invoice' => $invoice])
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection 