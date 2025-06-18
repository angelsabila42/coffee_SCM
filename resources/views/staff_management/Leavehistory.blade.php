
<!-- Validation -->
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

<h3>Leave History</h3>
<button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#addLeaveRecordModal">
    Add Leave Record
</button>

{{-- Add Leave Record Modal --}}
<div class="modal fade" id="addLeaveRecordModal" tabindex="-1" aria-labelledby="addLeaveRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeaveRecordModalLabel">Add Leave Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addLeaveRecordForm" action="{{ route('staff_management.leavehistory.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="lh_staff_id" class="form-label">Staff Member</label>
                        <select class="form-select @error('staff_id') is-invalid @enderror" id="lh_staff_id" name="staff_id" required>
                            <option value="">Select Staff</option>
                            {{-- $staffMembersForDropdown from your controller --}}
                            @foreach($staffMembersForDropdown as $staffMember)
                                <option value="{{ $staffMember->id }}" {{ old('staff_id') == $staffMember->id ? 'selected' : '' }}>{{ $staffMember->full_name }}</option>
                            @endforeach
                        </select>
                        @error('staff_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lh_leave_type" class="form-label"> Type</label>
                        <select class="form-select @error('leave_type') is-invalid @enderror" id="lh_leave_type" name="leave_type" required>
                            <option value="">Select Leave Type</option>
                            <option value="Annual Leave" {{ old('leave_type') == 'Annual Leave' ? 'selected' : '' }}>Annual Leave</option>
                            <option value="Sick Leave" {{ old('leave_type') == 'Sick Leave' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="Maternity Leave" {{ old('leave_type') == 'Maternity Leave' ? 'selected' : '' }}>Maternity Leave</option>
                            <option value="Paternity Leave" {{ old('leave_type') == 'Paternity Leave' ? 'selected' : '' }}>Paternity Leave</option>
                            <option value="Compassionate Leave" {{ old('leave_type') == 'Compassionate Leave' ? 'selected' : '' }}>Compassionate Leave</option>
                        </select>
                        @error('leave_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                       <label for="wa_work_center" class="form-label">Work Center</label>
                            <select class="form-select @error('work_center') is-invalid @enderror" id="wa_work_center" name="work_center" required>
                                <option value="">Select Work Center</option>
                                <option value="Kampala" {{ old('work_center') == 'Kampala' ? 'selected' : '' }}>Kampala</option>
                                <option value="Mbale" {{ old('work_center') == 'Mbale' ? 'selected' : '' }}>Mbale</option>
                                <option value="Jinja" {{ old('work_center') == 'Jinja' ? 'selected' : '' }}>Jinja</option>
                            </select>
                             @error('work_center')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="lh_start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="lh_start_date" name="start_date" required value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="lh_end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="lh_end_date" name="end_date" required value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lh_status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="lh_status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Leave ID</th>
            <th>Staff ID</th>
            <th>Full Name</th>
            <th>Work Center</th>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($leaveHistory as $leave)
            <tr>
                <td>{{ $leave->id }}</td>
                <td>{{ $leave->staff_id }}</td> {{-- Access via relationship --}}
                <td>{{ $leave->staff->full_name ?? 'N/A' }}</td> {{-- Access via relationship --}}
                <td>{{ $leave->staff->work_center ?? 'N/A' }}</td> 
                <td>{{ $leave->leave_type }}</td>
                <td>{{ $leave->start_date }}</td>
                <td>{{ $leave->end_date }}</td>
                <td>{{ $leave->status }}</td>
 
                <td>
                    <button type="button" class="btn btn-sm btn-info edit-leave-record-btn me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#editLeaveRecordModal"
                            data-id="{{ $leave->id }}">
                        Edit
                    </button>
                    <form action="{{ route('staff_management.leave-history.destroy', $leave->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this leave record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No leave records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Edit Leave Record Modal -->
<div class="modal fade" id="editLeaveRecordModal" tabindex="-1" aria-labelledby="editLeaveRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeaveRecordModalLabel">Edit Leave Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editLeaveRecordForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_lh_id" name="id">

                    <div class="mb-3">
                        <label for="edit_lh_staff_id" class="form-label">Staff Member</label>
                        <select class="form-select" id="edit_lh_staff_id" name="staff_id" required>
                            <option value="">Select Staff</option>
                            @foreach($staffMembersForDropdown as $staffMember)
                                <option value="{{ $staffMember->id }}">{{ $staffMember->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_lh_leave_type" class="form-label">Leave Type</label>
                        <select class="form-select" id="edit_lh_leave_type" name="leave_type" required>
                            <option value="">Select Leave Type</option>
                            <option value="Annual Leave">Annual Leave</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                            <option value="Compassionate Leave">Compassionate Leave</option>
                            <option value="Unpaid Leave">Unpaid Leave</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_lh_start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="edit_lh_start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_lh_end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edit_lh_end_date" name="end_date" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_lh_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_lh_status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>