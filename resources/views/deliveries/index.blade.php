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
    <div class="card-header d-flex justify-content-between align-items-center" style="background: #e0cfc1; color: #4b2e2e;">
        <div class="d-flex align-items-center">
            <span class="mr-2"><i class="fa fa-truck delivery" style="font-size: 1.5rem;"></i></span>
            <h4 class="card-title mb-0" style="color: #4b2e2e;">Delivery Requests</h4>
        </div>
        <div class="d-flex align-items-center">
            <div class="input-group input-group-sm ml-3" style="width: 150px;">
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
    <div class="card-body">
        <div class="table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th><i class="fa fa-hashtag text-secondary"></i> Delivery ID</th>
                        <th><i class="fa fa-coffee text-brown"></i> Coffee Type</th>
                        <th><i class="fa fa-balance-scale text-secondary"></i> Quantity</th>
                        <th><i class="fa fa-map-marker-alt text-danger"></i> Destination</th>
                        <th><i class="fa fa-info-circle text-info"></i> Status</th>
                        <th><i class="fa fa-user text-primary"></i> Assigned Driver</th>
                        <th><i class="fa fa-clock text-warning"></i> ETA</th>
                        <th><i class="fa fa-calendar text-success"></i> Date Ordered</th>
                        <th><i class="fa fa-cogs text-secondary"></i> Actions</th>
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
    <div class="card-footer clearfix">
        {{ $deliveries->links() }} {{-- Pagination links --}}
    </div>
</div>
@endsection
