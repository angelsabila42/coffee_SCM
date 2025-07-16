@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">Driver Management</h2>
        <a href="{{ route('transporter.drivers.create') }}" class="btn" style="background-color: #8B4513; color: white; border-radius: 20px;">
            <i class="bx bx-plus"></i> Add New Driver
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; border-left: 4px solid #8B4513;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-group"></i> All Drivers
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead style="background-color: #F5F5DC;">
                        <tr>
                            <th style="color: #8B4513;">Name</th>
                            <th style="color: #8B4513;">Email</th>
                            <th style="color: #8B4513;">Phone</th>
                            <th style="color: #8B4513;">License Number</th>
                            <th style="color: #8B4513;">Vehicle Number</th>
                            <th style="color: #8B4513;">Status</th>
                            <th style="color: #8B4513;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($drivers as $driver)
                        <tr>
                            <td><strong>{{ $driver->name }}</strong></td>
                            <td>{{ $driver->email }}</td>
                            <td>{{ $driver->phone ?? 'Not provided' }}</td>
                            <td>{{ $driver->license_number ?? 'Not provided' }}</td>
                            <td>{{ $driver->vehicle_number ?? 'Not assigned' }}</td>
                            <td>
                                @if($driver->is_available ?? true)
                                    <span class="badge badge-success">Available</span>
                                @else
                                    <span class="badge badge-warning">On Delivery</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('transporter.drivers.edit', $driver->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bx bx-edit"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $driver->id }})">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No drivers found. <a href="{{ route('transporter.drivers.create') }}">Add your first driver</a></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $drivers->links() }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this driver? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Driver</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.table th {
    border-top: none;
    font-weight: 600;
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.8em;
    border-radius: 15px;
}

.btn {
    border-radius: 20px;
    transition: all 0.2s;
    margin-right: 5px;
}

.btn:hover {
    transform: scale(1.05);
}

.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}

h2 {
    font-weight: 700;
}

.alert {
    border-radius: 10px;
}
</style>
@endsection

@section('scripts')
<script>
function confirmDelete(driverId) {
    document.getElementById('deleteForm').action = '/transporter/drivers/' + driverId;
    $('#deleteModal').modal('show');
}
</script>
@endsection
