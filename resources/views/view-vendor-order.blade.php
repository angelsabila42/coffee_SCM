@extends('layouts.app')
@section('page-title', 'Order Summary')

@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection

@section('content')
<div class="container">
    <div class="modern-card p-4">
        <h4 class="mt-3 mb-5"><strong> OrderID: {{$order->orderID}} </strong></h4>

        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-3"><b>Coffee Type: </b> {{$order->coffeeType}} </p>
            <p class="mb-3"><b>Date Sent: </b> {{$order->created_at}} </p>
        </div>
        <p class="mb-3"><b>Quantity: </b> {{$order->quantity}}kgs </p>
        <p class="mb-3"><b>Warehouse name: </b> {{$order->workCenter->centerName}} </p>
        <p class="mb-5">
            <span class="text-danger"><b>Deadline: </b></span>
        {{$order->deadline}} </p>

        <div x-data="vendorDispatch"
         data-show-form= "{{old('declineReason')? 'true' : 'false' }}" 
         x-init= "showForm = $el.dataset.showForm ==='true'; init();">
        @livewire('vendor-order-details', ['orderId' => $order->id])
            <div class="d-flex justify-content-end">
                @include('partials.vendor-order-decline-form')
            </div>
        </div>
    </div>
    
</div>

@endsection