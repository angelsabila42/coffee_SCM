@extends('layouts.app1')
@section('page-title', 'Inventory Management')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection 
@section('content')
@include('layouts.inven_body')
@endsection
