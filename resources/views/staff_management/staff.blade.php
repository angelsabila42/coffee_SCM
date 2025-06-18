@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Staff Management</h2>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                   {{-- Dynamically get total staff count --}}
                    <h3>{{ $totalStaffCount ?? 0 }}</h3> 
                    <p>Staff</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center">
                <div class="card-body">
                    {{-- Dynamically get absent staff count --}}
                    <h3>{{ $absentStaffCount ?? 0 }}</h3> {{-- $absentStaffCount is passed from controller --}}
                    <p>Absent Staff</p>
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
            <a class="nav-link active" id="staff-tab" data-bs-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="true">Staff</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="work-tab" data-bs-toggle="tab" href="#work" role="tab" aria-controls="work" aria-selected="false">Work Assignment History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="leave-tab" data-bs-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="false">Leave History</a>
        </li>
    </ul>

    {{-- Universal Session Messages  --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif
    {{-- General Validation Errors  --}}
    @if ($errors->any() && !session('open_add_modal') && !session('open_workassignment_modal')) {{-- Don't show general errors if a specific modal is being re-opened --}}
        <div class="alert alert-danger mt-3">
            <h6>Please correct the following errors:</h6>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        @if ($errors->any() && session('open_leavehistory_modal'))
    <div class="alert alert-danger mt-3">
        <h6>Please correct the following errors for Leave Record:</h6>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="tab-content mt-3">
        {{-- Staff Tab Content --}}
        <div class="tab-pane fade show active" id="staff" role="tabpanel" aria-labelledby="staff-tab">
            <button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#addStaffModal">
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
            <!-- Edit Staff Modal 
            <div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                             <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                       </div>
                       <div class="modal-body">
                             <form id="editStaffForm" method="POST"> {{-- Action will be set by JS --}}
                            {{-- @csrf --}} 
                             {{-- Use PUT for updates --}}
                            <input type="hidden" id="edit_staff_id" name="id"> {{-- Hidden input for staff ID --}}
                             -->

                                <h6>Staff details</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="full_name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" required value="{{ old('full_name') }}">
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                            <option value="">Select Role</option>
                                            <option value="Logistics Supervisor" {{ old('role') == 'Logistics Supervisor' ? 'selected' : '' }}>Logistics Supervisor</option>
                                            <option value="Supervisor" {{ old('role') == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                                            <option value="Warehouse Clerk" {{ old('role') == 'Warehouse Clerk' ? 'selected' : '' }}>Warehouse Clerk</option>
                                            <option value="QA" {{ old('role') == 'QA' ? 'selected' : '' }}>QA</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="work_center" class="form-label">Work Center</label>
                                        <select class="form-select @error('work_center') is-invalid @enderror" id="work_center" name="work_center" required>
                                            <option value="">Work Center</option>
                                            <option value="Kampala" {{ old('work_center') == 'Kampala' ? 'selected' : '' }}>Kampala</option>
                                            <option value="Mbale" {{ old('work_center') == 'Mbale' ? 'selected' : '' }}>Mbale</option>
                                            <option value="Jinja" {{ old('work_center') == 'Jinja' ? 'selected' : '' }}>Jinja</option>
                                        </select>
                                        @error('work_center')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value=""> Status</option>
                                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Suspended" {{ old('status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                            <option value="On Leave" {{ old('status') == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" required value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

            <table class="table table-bordered mt-3"> 
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
                    @forelse($staff as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->full_name }}</td>
                            <td>{{ $member->work_center }}</td>
                            <td>{{ $member->role }}</td>
                            <td>{{ $member->status }}</td>
                            <td>{{ $member->phone_number }}</td>
                            <td>{{ $member->email }}</td>
                            <td>
                                {{-- Edit Button --}}
                                <button type="button" class="btn btn-sm btn-info edit-staff-btn me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editStaffModal"
                                        data-id="{{ $member->id }}">
                                    Edit
                                </button>

                                {{-- Delete Form --}}
                                <form action="{{ route('staff_management.staff.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $member->full_name }}?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No staff members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> 
        <!-- Work Assignment History Tab Content -->s
        <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
            @include('staff_management.Workassignment', [
                'workAssignments' => $workAssignments, 
                'staffMembersForDropdown' => $staffMembersForDropdown
            ])
        </div>
        <!-- Leave History Tab Content -->
        <div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="leave-tab">
            @include('staff_management.Leavehistory', [
                'leaveHistory' => $leaveHistory,
                'staffMembersForDropdown' => $staffMembersForDropdown
            ])
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Staff Tab related JavaScript
    @if ($errors->any() && session('open_add_modal'))
        var addStaffModal = new bootstrap.Modal(document.getElementById('addStaffModal'));
        addStaffModal.show();
    @endif

    var editStaffModal = document.getElementById('editStaffModal');
    if (editStaffModal) { // Check if the modal exists within the current view
        editStaffModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var staffId = button.getAttribute('data-id');

            fetch('/staff_management/staff/' + staffId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_staff_id').value = data.id;
                    document.getElementById('edit_full_name').value = data.full_name;
                    document.getElementById('edit_role').value = data.role;
                    document.getElementById('edit_work_center').value = data.work_center;
                    document.getElementById('edit_status').value = data.status;
                    document.getElementById('edit_phone_number').value = data.phone_number;
                    document.getElementById('edit_email').value = data.email;

                    document.getElementById('edit_role').value = data.role;
                    document.getElementById('edit_work_center').value = data.work_center;
                    document.getElementById('edit_status').value = data.status;

                    document.getElementById('editStaffForm').action = '/staff-management/staff/' + data.id;
                })
                .catch(error => console.error('Error fetching staff data:', error));
        });
    }

    // Work Assignment Tab related JavaScript
    @if ($errors->any() && session('open_workassignment_modal'))
        var addWorkAssignmentModal = new bootstrap.Modal(document.getElementById('addWorkAssignmentModal'));
        addWorkAssignmentModal.show();
        var workTabLink = document.getElementById('work-tab');
        var tab = new bootstrap.Tab(workTabLink);
        tab.show();
    @endif

    var editWorkAssignmentModal = document.getElementById('editWorkAssignmentModal');
    if (editWorkAssignmentModal) {
        editWorkAssignmentModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var assignmentId = button.getAttribute('data-id');

            fetch('/staff_management/workassignment/' + assignmentId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_wa_id').value = data.id;
                    document.getElementById('edit_wa_staff_id').value = data.staff_id;
                    document.getElementById('edit_wa_work_center').value = data.work_center;
                    document.getElementById('edit_wa_assignment_type').value = data.assignment_type;
                    document.getElementById('edit_wa_start_date').value = data.start_date;
                    document.getElementById('edit_wa_end_date').value = data.end_date;
                    document.getElementById('edit_wa_status').value = data.status;
                    document.getElementById('edit_wa_description').value = data.description;

                    document.getElementById('editWorkAssignmentForm').action = '/staff_management/workassignment/' + data.id;
                })
                .catch(error => console.error('Error fetching work assignment data:', error));
        });   
    }

    // Leave History Tab related JavaScript
         @if ($errors->any() && session('open_leavehistory_modal'))
        var addLeaveModal = new bootstrap.Modal(document.getElementById('addLeavehistoryModal'));
        addLeaveModal.show();
        var leaveTabLink = document.getElementById('leave-tab');
        var tab = new bootstrap.Tab(leaveTabLink);
        tab.show();
    @endif

    var editLeaveModal = document.getElementById('editLeavehistoryModal');
    if (editLeaveModal) {
        editLeaveModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var leaveId = button.getAttribute('data-id');

            fetch('/staff-management/Leavehistory/' + leaveId) // You will need a route and controller method for this
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_leave_id').value = data.id;
                    document.getElementById('edit_leave_staff_id').value = data.staff_id;
                    document.getElementById('edit_leave_type').value = data.leave_type;
                    document.getElementById('edit_leave_start_date').value = data.start_date;
                    document.getElementById('edit_leave_end_date').value = data.end_date;
                    document.getElementById('edit_leave_reason').value = data.reason;
                    document.getElementById('edit_leave_status').value = data.status;

                    document.getElementById('editLeaveForm').action = '/staff-management/leave-history/' + data.id;
                })
                .catch(error => console.error('Error fetching leave data:', error));
        });
    }
});
</script>
@endpush