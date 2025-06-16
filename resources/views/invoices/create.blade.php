@extends('layouts.app')

@section('page-title', 'Create Invoice')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Create New Invoice</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            @include('invoices._form')
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection 