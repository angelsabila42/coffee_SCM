@extends('layouts.app')
@section('page-title', 'Orders')
@section('sidebar-items')
@include('layouts.sidebar-items.importer')
@endsection
@section('content')
<livewire:importer-order/>
@endsection