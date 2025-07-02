@extends('layouts.app')
@section('page-title', 'Orders')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection
@section('content')
@livewire('orders')
@endsection