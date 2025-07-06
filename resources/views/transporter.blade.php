@extends('layouts.app')
@section('page-title', 'Transporter')
@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection
@section('content')
@include('layouts.transporters-content')
@endsection