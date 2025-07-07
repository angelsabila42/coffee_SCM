@extends('layouts.app')
@section('page-title', 'Importer Dashboard')
@section('sidebar-items')
@include('layouts.sidebar-items.importer')
@endsection
@section('content')
@include('layouts.importer_dashboard')
@endsection

