@extends('layouts.app')
@section('page-title', 'Order Summary')

@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
    <div class="modern-card p-4 mb-4">
        <h5 class="mt-3 mb-4"><strong> OrderID: {{$order->orderID}} </strong></h5>

        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-3"><b>From: </b> {{$order->importerModel->name}} </p>
            <p class="mb-3"><b>Destination</b> {{$order->destination}} </p>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-3"><b>Coffee Type: </b> {{$order->coffeeType}} </p>
            <p class="mb-3"><b>Date Sent: </b> {{$order->created_at}} </p>
        </div>
        <p class="mb-3"><b>Grade: </b> {{$order->grade}}</p>
        <p class="mb-3"><b>Quantity: </b> {{$order->quantity}}kgs </p>
        <p class="mb-5">
            <span class="text-danger"><b>Deadline: </b></span>
        {{$order->deadline}} </p>

        <div x-data="{showForm: false}">
        <div class="d-flex justify-content-between align-items-center">
            @livewire('admin-order-details', ['orderId' => $order->id])
            <div class="d-flex">   
                <button type= "button" class="btn btn-light btn-fill mr-2" onclick="window.location= '{{route('order.download-in', $order->id)}}' " >Download</button>
            </div>
        </div>
            <div class="d-flex justify-content-start">
                @include('partials.admin-order-decline-form')
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="row">
    <livewire:order-status-logger :order="$order" />
    </div>
</div>
@endsection