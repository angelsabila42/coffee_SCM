@extends('layouts.app')

@section('page-title', 'Transporter Deliveries')

@section('sidebar-item')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
    @livewire('transporter-delivery-dashboard')
@endsection