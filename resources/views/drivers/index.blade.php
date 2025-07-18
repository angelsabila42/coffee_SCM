@extends('layouts.app')

@section('page-title', 'Drivers')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Drivers</h2>
        <a href="{{ route('drivers.create') }}" class="btn btn-success">Add New Driver</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Transporter Company</th>
                <th>License No.</th>
                <th>Vehicle No.</th>
                <th>Experience</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($drivers as $driver)
                <tr>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->email }}</td>
                    <td>{{ $driver->phone ?? 'N/A' }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $driver->transporter_company ?? 'Not Assigned' }}</span>
                    </td>
                    <td>{{ $driver->license_number ?? 'N/A' }}</td>
                    <td>{{ $driver->vehicle_number ?? 'N/A' }}</td>
                    <td>{{ $driver->experience ? $driver->experience . ' years' : 'N/A' }}</td>
                    <td>
                        @if($driver->is_available)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-warning">Busy</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('drivers.show', $driver->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this driver?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center">No drivers found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div>
        {{ $drivers->links() }}
    </div>
</div>
@endsection
