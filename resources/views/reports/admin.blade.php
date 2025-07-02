@extends('layouts.app')
@section('page-title', 'Reports')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection
@section('content')
@livewire('reports')
@endsection