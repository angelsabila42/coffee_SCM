@extends('layouts.app')

@section('page-title', 'Delivery Details')

@section('sidebar-item')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Delivery Details</h4>
        <a href="{{ route('deliveries.index') }}" class="btn btn-secondary">Back</a>
    </div>
    <div class="card-body">
        @if(isset($delivery))
            <div class="row">
                <div class="col-md-6">
                    <h5>Delivery Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Delivery ID:</strong></td>
                            <td>{{ $delivery->delivery_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Coffee Type:</strong></td>
                            <td>{{ $delivery->coffee_type }}</td>
                        </tr>
                        <tr>
                            <td><strong>Quantity:</strong></td>
                            <td>{{ $delivery->quantity }} kg</td>
                        </tr>
                        <tr>
                            <td><strong>Destination:</strong></td>
                            <td>{{ $delivery->delivery_destination }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>{{ $delivery->status }}</td>
                        </tr>
                        <tr>
                            <td><strong>Assigned Driver:</strong></td>
                            <td>{{ $delivery->assigned_driver }}</td>
                        </tr>
                        <tr>
                            <td><strong>ETA:</strong></td>
                            <td>{{ $delivery->eta ? \Carbon\Carbon::parse($delivery->eta)->format('Y-m-d') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date Ordered:</strong></td>
                            <td>{{ $delivery->date_ordered ? \Carbon\Carbon::parse($delivery->date_ordered)->format('Y-m-d') : 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('deliveries.edit', $delivery->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('deliveries.destroy', $delivery->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        @else
            <div class="alert alert-info">Delivery not found.</div>
        @endif
    </div>
</div>
@endsection 