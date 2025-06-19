<!-- Validation Errors -->
@if ($errors->any() && session('open_work_assignment_modal'))
    <div class="alert alert-danger mt-3">
        <h6>Please correct the following errors for Work Assignment:</h6>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h3>Work Assignment History</h3>
<button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#addWorkAssignmentModal">
    Assign Work
</button>

{{-- Add Work Assignment Modal --}}
<div class="modal fade" id="addWorkAssignmentModal" tabindex="-1" aria-labelledby="addWorkAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWorkAssignmentModalLabel">Add Work Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addWorkAssignForm" action="{{ route('staff_management.workassignment.store') }}" method="POST">
                    @csrf

                    <!-- Using a select dropdown for staff_id for better UX and data integrity -->
                    <div class="mb-3">
                        <label for="wa_staff_id" class="form-label">Staff Member</label>
                        <select class="form-select @error('staff_id') is-invalid @enderror" id="wa_staff_id" name="staff_id" required>
                            <option value="">Select Staff</option>
                            <!-- $staffMembersForDropdown is passed from the controller -->
                            @foreach($staffMembersForDropdown as $staffMember)
                                <option value="{{ $staffMember->id }}" {{ old('staff_id') == $staffMember->id ? 'selected' : '' }}>{{ $staffMember->full_name }}</option>
                            @endforeach
                        </select>
                        @error('staff_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
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
                            <label for="wa_start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="wa_start_date" name="start_date" required value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="wa_end_date" class="form-label">End Date </label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="wa_end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Work</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Assignment ID</th>
            <th>Staff ID</th>
            <th>Staff Name</th>
            <th>Work Center</th>
            <th>Role</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($workAssignments as $assignment)
            <tr>
                <td>{{ $assignment->assignment_id }}</td>
                <td>{{ $assignment->staff_id }}</td>
                <td>{{ $assignment->staff->full_name ?? 'N/A' }}</td>
                <td>{{ $assignment->work_center }}</td>
                <td>{{ $assignment->role }}</td>
                <td>{{ $assignment->start_date }}</td>
                <td>{{ $assignment->end_date ?? 'N/A' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-info edit-work-assignment-btn me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#editWorkAssignmentModal"
                            data-id="{{ $assignment->assignment_id }}">
                        Edit
                    </button>
                    <form action="{{ route('staff_management.workassignment.destroy', $assignment->assignment_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No work assignments found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Edit Work Assignment Modal  -->
<div class="modal fade" id="editWorkAssignmentModal" tabindex="-1" aria-labelledby="editWorkAssignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWorkAssignmentModalLabel">Edit Work Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editWorkAssignmentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_wa_id" name="id">

                    <div class="mb-3">
                        <label for="edit_wa_staff_id" class="form-label">Staff Member</label>
                        <select class="form-select" id="edit_wa_staff_id" name="staff_id" required>
                            <option value="">Select Staff</option>
                            @foreach($staffMembersForDropdown as $staffMember)
                                <option value="{{ $staffMember->id }}">{{ $staffMember->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_wa_work_center" class="form-label">Work Center</label>
                            <select class="form-select" id="edit_wa_work_center" name="work_center" required>
                                <option value="">Select Work Center</option>
                                <option value="Kampala">Kampala</option>
                                <option value="Mbale">Mbale</option>
                                <option value="Jinja">Jinja</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_wa_role" class="form-label">Role</label>
                            <select class="form-select" id="edit_wa_role" name="role" required>
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
                            <label for="edit_wa_start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="edit_wa_start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_wa_end_date" class="form-label">End Date (Optional)</label>
                            <input type="date" class="form-control" id="edit_wa_end_date" name="end_date">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Work Assignment Modal logic
    const editWorkAssignmentModal = document.getElementById('editWorkAssignmentModal');
    const editWorkAssignmentForm = document.getElementById('editWorkAssignmentForm');
    let currentEditAssignmentId = null;

    // Delegate click event for edit buttons
    document.querySelectorAll('.edit-work-assignment-btn').forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            const assignmentId = btn.getAttribute('data-id');
            currentEditAssignmentId = assignmentId;
            // Fetch assignment data
            fetch('/staff-management/workassignment/' + assignmentId)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_wa_id').value = data.assignment_id;
                    document.getElementById('edit_wa_staff_id').value = data.staff_id;
                    document.getElementById('edit_wa_work_center').value = data.work_center;
                    document.getElementById('edit_wa_role').value = data.role;
                    document.getElementById('edit_wa_start_date').value = data.start_date;
                    document.getElementById('edit_wa_end_date').value = data.end_date || '';
                   
                    // Set form action
                    editWorkAssignmentForm.setAttribute('action', '/staff-management/workassignment/' + data.assignment_id);
                    // Show modal (in case not triggered by data-bs-toggle)
                    var modal = bootstrap.Modal.getOrCreateInstance(editWorkAssignmentModal);
                    modal.show();
                })
                .catch(error => {
                    alert('Failed to load assignment data.');
                    console.error(error);
                });
        });
    });
    // Ensure form action is set before submit
    editWorkAssignmentForm.addEventListener('submit', function(e) {
        if (!editWorkAssignmentForm.action.match(/\/staff-management\/workassignment\/[\w-]+$/)) {
            e.preventDefault();
            if (currentEditAssignmentId) {
                editWorkAssignmentForm.setAttribute('action', '/staff-management/workassignment/' + currentEditAssignmentId);
                editWorkAssignmentForm.submit();
            } else {
                alert('Assignment ID missing. Please try again.');
            }
        }
    });
});
</script>