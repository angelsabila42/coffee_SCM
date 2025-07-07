@extends('layouts.app')

@section('page-title', 'Create Payment')

@section('sidebar-item')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Create New Payment Record</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data"> {{-- Add enctype for file upload --}}
            @csrf
            @include('payments._form', ['invoices' => $invoices])
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection 