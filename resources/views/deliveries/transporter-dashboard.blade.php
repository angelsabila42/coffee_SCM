@extends('layouts.app')

@section('page-title', 'Transporter Deliveries')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')

@section('content')
    @livewire('transporter-delivery-dashboard')
@endsection