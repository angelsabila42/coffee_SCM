@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Staff Management</h2>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h3>100</h3>
                    <p>Staff</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h3>5</h3>
                    <p>Absent</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    <h3>4</h3>
                    <p>Warehouses</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="staffTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="staff-tab" data-bs-toggle="tab" href="#staff" role="tab">Staff</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="work-tab" data-bs-toggle="tab" href="#work" role="tab">Work Assignment History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="leave-tab" data-bs-toggle="tab" href="#leave" role="tab">Leave History</a>
        </li>
    </ul>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
    Add Staff
</button>

<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStaffForm" action="{{ route('staff_management.staff.store') }}" method="POST">
                    @csrf

                    <h6>Staff details</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                    
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="Logistics Supervisor">Logistics Supervisor</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Warehouse Clerk">Warehouse Clerk</option>
                                <option value="QA">QA</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="work_center" class="form-label">Work Center</label>
                            <select class="form-select" id="work_center" name="work_center" required>
                                <option value="">Work Center</option>
                                <option value="Kampala">Kampala</option>
                                <option value="Mbale">Mbale</option>
                                <option value="Jinja">Jinja</option>
                            </select>
                        </div>
                   
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value=""> Status</option>
                                <option value="Active">Active</option>
                                <option value="Suspended">Suspended</option>
                                <option value="On Leave">On Leave</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Table -->
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Staff ID</th>
            <th>Full Name</th>
            <th>Work Center</th>
            <th>Role</th>
            <th>Status</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staff as $member)
            <tr>
                <td>{{ $member->id }}</td>
                <td>{{ $member->full_name }}</td>
                <td>{{ $member->work_center }}</td>
                <td>{{ $member->role }}</td>
                <td>{{ $member->status }}</td>
                <td>{{ $member->phone_number }}</td>
                <td>{{ $member->email }}</td>
                <td>
                    <form action="{{ route('staff_management.staff.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
   

@endsection
