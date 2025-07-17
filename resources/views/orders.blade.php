@extends('layouts.app')
@section('page-title', 'Orders')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection

@section('report-btn')
<div class="d-flex gap-2">
    <a href="{{ route('deliveries.index') }}" class="btn btn-outline-primary">
        <i class="bx bx-truck mr-1"></i> Delivery Requests
    </a>
    <a href="{{ route('analytics') }}" class="btn btn-outline-secondary">
        <i class="bx bx-chart mr-1"></i> Analytics
    </a>
</div>
@endsection

@section('content')
@livewire('orders')
@endsection