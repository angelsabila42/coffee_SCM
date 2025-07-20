@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection
@section('content')
@include('layouts.transporter_transactions')
@endsection

