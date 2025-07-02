@extends('layouts.app')
@section('page-title', 'Orders')
@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection
@section('content')
<livewire:vendor-order/>
@endsection