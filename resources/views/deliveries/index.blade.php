@extends('layouts.app')
@section('page-title', 'Delivery Requests')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection

@section('sidebar-item')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <h3 class="mb-4 font-weight-bold" style="color:#222">Delivery Requests</h3>
            <div class="d-flex flex-wrap align-items-center mb-3 justify-content-between">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="form mr-3 position-relative">
                        <span class="position-absolute" style="left:10px;top:8px;color:#aaa;"><i class="nc-icon nc-zoom-split"></i></span>
                        <input type="text" class="form-control pl-4" placeholder="Search" style="width:200px;">
                    </div>
                    <button class="btn btn-light btn-fill btn-sm d-flex align-items-center ml-2" style="color:#6c757d;">
                        <span class="mr-2"><i class='bx bx-filter'></i></span>Filter
                    </button>
                </div>
                <a href="{{ route('deliveries.create') }}" class="btn btn-primary btn-sm ml-2"><i class="nc-icon nc-simple-add"></i> New</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead class="bg-light">
                        <tr style="color:#6c757d;">
                            <th>Delivery ID</th>
                            <th>Coffee Type</th>
                            <th>Quantity</th>
                            <th>Destination</th>
                            <th>Status</th>
                            <th>Assigned Driver</th>
                            <th>ETA</th>
                            <th>Date Ordered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveries as $delivery)
                            <tr>
                                <td>{{ $delivery->delivery_id }}</td>
                                <td>{{ $delivery->coffee_type }}</td>
                                <td>{{ $delivery->quantity }} kg</td>
                                <td>{{ $delivery->delivery_destination }}</td>
                                <td>
                                    <span class="badge badge-secondary">{{ $delivery->status }}</span>
                                </td>
                                <td>{{ $delivery->assigned_driver }}</td>
                                <td>{{ $delivery->eta ? \Carbon\Carbon::parse($delivery->eta)->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $delivery->date_ordered ? \Carbon\Carbon::parse($delivery->date_ordered)->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('deliveries.edit', $delivery->id) }}" class="btn btn-info btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('deliveries.destroy', $delivery->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix bg-white border-0">
            {{ $deliveries->links() }}
        </div>
    </div>
</div>
@endsection
