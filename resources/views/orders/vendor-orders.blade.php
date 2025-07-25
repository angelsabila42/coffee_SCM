@extends('layouts.app')
{{-- @section('page-title', 'Orders') --}}
@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection
@section('content')
<h3 class="mb-3 font-weight-bold">Orders</h3>
<livewire:vendor-order/>
@endsection