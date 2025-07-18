@extends('layouts.app')
@section('sidebar-items')
@include('layouts.sidebar-items.importer')
@endsection
@section('content')
    
@include('importer.ImporterPartial')
 <div class="card d-flex flex-row flex-start ">
{{-- <a href="{{ route('payments.download', $order->id) }}" class="btn btn-info m-3">
    Download Payment Details
</a> --}}
    </div>
@endsection

