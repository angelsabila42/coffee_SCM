@extends('layouts.app')
@section('page-title', 'Delivery Requests')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection

@section('sidebar-item')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Delivery Requests</h4>
        <div class="d-flex align-items-center">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control" placeholder="Search">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('deliveries.create') }}" class="btn btn-primary btn-sm ml-2"><i class="nc-icon nc-simple-add"></i> New</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-sm text-nowrap">
            <thead>
                <tr>
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
                        <td>{{ $delivery->status }}</td>
                        <td>{{ $delivery->assigned_driver }}</td>
                        <td>{{ $delivery->eta ? \Carbon\Carbon::parse($delivery->eta)->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $delivery->date_ordered ? \Carbon\Carbon::parse($delivery->date_ordered)->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('deliveries.edit', $delivery->id) }}" class="btn btn-info btn-sm">Edit</a>
                            <form action="{{ route('deliveries.destroy', $delivery->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        {{ $deliveries->links() }} {{-- Pagination links --}}
    </div>
</div>
@endsection
