@extends('layouts.app')
@section('page-title', 'Reports')
@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection
@section('content')
    @livewire('vendor-reports')
@endsection 