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

{{-- Leave History Table in a white card --}}

    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <h4 class="mb-0">Leave History</h4>
       {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLeaveRecordModal">
            + New
        </button> --}}
    </div>
    <livewire:leave-history />
    <div class="card-body table-full-width table-responsive">
        <table class="table table-sm table-hover mb-0 align-middle" style="font-size: 14px; line-height: 1.2;">
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Staff</th>
                    <th>Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaveHistory as $leave)
                    <tr>
                        <td>{{ $leave->id ?? ($leave->leave_id ?? '') }}</td>
                        <td>{{ $leave->staff->full_name ?? $leave->staff_id }}</td>
                        <td>{{ $leave->leave_type }}</td>
                        <td>{{ $leave->start_date }}</td>
                        <td>{{ $leave->end_date }}</td>
                        <td x-data="{
                                selectedStatus: '{{$leave->status}}',
                                statuses: ['Pending', 'Approved', 'Rejected', 'Cancelled'],
                                badgeClass: function(status) {
                                    if (status === 'Approved') return 'bg-success text-white';
                                    if (status === 'Pending') return 'bg-warning text-dark';
                                    if (status === 'Rejected') return 'bg-danger text-white';
                                    return 'bg-secondary text-white';
                                },
                                async updateStatus() {
                                    try {
                                        const response = await fetch(`/staff-management/leavehistory/${{{ $leave->id }}}/status`, {
                                            method: 'PATCH',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.content
                                            },
                                            body: JSON.stringify({ status: this.selectedStatus })
                                        });
                                        
                                        if (!response.ok) throw new Error('Failed to update status');
                                        
                                        const data = await response.json();
                                        if (data.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Status updated',
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000
                                            });
                                        }
                                    } catch (err) {
                                        console.error(err);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Failed to update status',
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000
                                        });
                                    }
                                }
                            }">
                            <select 
                                x-model="selectedStatus" 
                                :class="badgeClass(selectedStatus)"
                                class="btn btn-sm dropdown-toggle px-2 rounded"
                                @change="updateStatus()"
                                style="width: auto; cursor: pointer;"
                            >
                                <template x-for="status in statuses">
                                    <option :value="status" 
                                            :selected="status === selectedStatus" 
                                            x-text="status"></option>
                                </template>
                            </select>
                        </td>
                        <td>
                            <div>
                                <button type="button" class="btn btn-sm btn-info edit-leave-record-btn" 
                                    data-id="{{ $leave->id }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editLeaveRecordModal">
                                    Edit
                                </button>
                                <form action="{{ route('staff_management.leavehistory.destroy', $leave) }}" method="POST" style="display: none;" id="delete-leave-form-{{ $leave->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button class="btn btn-sm btn-danger" onclick="confirmDeleteLeaveHistory('{{ $leave->id }}')"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No leave records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


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

<!-- Edit Leave Record Modal -->n
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editLeaveModal = document.getElementById('editLeaveRecordModal');
    if (editLeaveModal) {
        editLeaveModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var leaveId = button.getAttribute('data-id');
            if (!leaveId) return;
            fetch('/staff-management/leavehistory/' + leaveId)
                .then(response => response.json())
                .then(function(data) {
                    document.getElementById('edit_lh_id').value = data.id;
                    document.getElementById('edit_lh_staff_id').value = data.staff_id;
                    document.getElementById('edit_lh_leave_type').value = data.leave_type;
                    document.getElementById('edit_lh_start_date').value = data.start_date;
                    document.getElementById('edit_lh_end_date').value = data.end_date;
                    document.getElementById('edit_lh_status').value = data.status;
                    document.getElementById('editLeaveRecordForm').setAttribute('action', '/staff-management/leavehistory/' + data.id);
                })
                .catch(error => {
                    alert('Failed to load leave record data.');
                    console.error(error);
                });
        });
    }
});

function confirmDeleteLeaveHistory(leaveId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-leave-form-' + leaveId).submit();
        }
    })
}
</script>
