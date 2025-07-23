@extends('layouts.app')
@section('content')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection
<div class="container">
    <h1>Staff Management</h1>
   
    <!-- Summary Cards -->
   <div class="row mb-4 card-row-custom">
    <div class="col-md-4 mb-3">
        <div class="card custom-card staff-card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text-right">
                    <div class="main-number">{{ $totalStaffCount ?? 0 }}</div>
                    <div class="sub-text">Staff</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card custom-card absent-staff-card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="icon-wrapper">
                    <i class="fas fa-user-minus"></i>
                </div>
                <div class="text-right">
                    <div class="main-number">{{ $absentStaffCount ?? 0 }}</div>
                    <div class="sub-text">Absent Staff</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card custom-card warehouse-card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="icon-wrapper">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="text-right">
                    <div class="main-number">10</div>
                    <div class="sub-text">Warehouses</div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Tabs -->
    <div class="modern-tabs mb-5">
        <ul class="nav nav-tabs" id="staffTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="staff-tab" data-bs-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="true">Staff</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="work-tab" data-bs-toggle="tab" href="#work" role="tab" aria-controls="work" aria-selected="false">Work Assignment History</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="leave-tab" data-bs-toggle="tab" href="#leave" role="tab" aria-controls="leave" aria-selected="false">Leave History</a>
            </li>
        </ul>
        <div class="tab-content" id="staffTabsContent">
            {{-- Staff Tab Content --}}
            <div class="tab-pane fade show active" id="staff" role="tabpanel" aria-labelledby="staff-tab">
                
                    <div class="card-header d-flex justify-content-between align-items-center bg-white">
                        <h4 class="mb-0">Staff</h4>
                       <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                            + New
                        </button>

                    </div>
                    {{-- <livewire:staff-model/> --}}
                       <!-- Staff Details Panel -->
            <div id="staffDetailsPanel" class="staff-details-panel d-none">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Staff Details</h5>
                        <button type="button" class="btn-close" id="closeStaffDetails"></button>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="profile-picture-container">
                                <img id="staffProfilePicture" src="{{ $member->profile_picture_url ?? asset('assets/img/default-avatar.png') }}" alt="Profile Picture" class="rounded-circle profile-picture mb-2">
                                <form id="profilePictureForm" class="mt-2">
                                    @csrf
                                    <label for="profilePictureInput" class="btn btn-sm btn-outline-primary">
                                        Change Picture
                                    </label>
                                    <input type="file" id="profilePictureInput" name="profile_picture" class="d-none" accept="image/*">
                                </form>
                            </div>
                        </div>
                        <div class="staff-info">
                            <h6 class="staff-name mb-3"></h6>
                            <div class="info-row">
                                <span class="info-label">Staff ID:</span>
                                <span class="staff-id"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Role:</span>
                                <span class="staff-role"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="staff-status"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phone:</span>
                                <span class="staff-phone"></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="staff-email"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff Tab Content End -->
                     <div class="card-body table-full-width table-responsive">
                        <table class="table table-sm table-hover mb-0 align-middle" style="font-size: 14px; line-height: 1.2;">

                            <thead>
                            <tr>
                            <th>Staff ID</th>
                            <th>Full Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th >Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $member)
                            <tr class="staff-row" data-id="{{ $member->id }}" style="cursor:pointer;">
                                <td>{{ $member->id }}</td>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->role }}</td>
                                <td x-data="{
                                        selectedStatus: '{{$member->status}}',
                                        statuses: ['Active', 'Suspended', 'On Leave'],
                                        badgeClass: function(status) {
                                            if (status === 'Active') return 'bg-success text-white';
                                            if (status === 'On Leave') return 'bg-warning text-dark';
                                            if (status === 'Suspended') return 'bg-danger text-white';
                                            return 'bg-secondary text-white';
                                        },
                                        updateStatus() {
                                            const staffId = {{ $member->id }};
                                            const newStatus = this.selectedStatus;
                                            fetch('/staff-management/staff/' + staffId + '/status', {
                                                method: 'PATCH',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.content || '{{ csrf_token() }}',
                                                    'Accept': 'application/json'
                                                },
                                                body: JSON.stringify({ status: newStatus })
                                            })
                                            .then(response => {
                                                if (!response.ok) throw new Error('Network response was not ok');
                                                return response.json();
                                            })
                                            .then(data => {
                                                if (data.success) {
                                                    const select = $el.querySelector('select');
                                                    select.className = 'form-control form-control-sm badge badge-sm ' + this.badgeClass(newStatus);
                                                    updateAbsentStaffCard();
                                                    if (window.Swal) {
                                                        Swal.fire({
                                                            toast: true,
                                                            position: 'top-end',
                                                            icon: 'success',
                                                            title: 'Status updated',
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                        });
                                                    } else {
                                                        alert('Status updated successfully!');
                                                    }
                                                } else {
                                                    alert(data.message || 'Failed to update status.');
                                                }
                                            })
                                            .catch((err) => alert('Failed to update status: ' + err.message));
                                        }
                                    }"
                                    x-init="selectedStatus = '{{$member->status}}'; $nextTick(() => { const select = $el.querySelector('select'); select.className = 'form-control form-control-sm badge badge-sm ' + badgeClass(selectedStatus); })"
                                >
                                    <select
                                        class="form-control form-control-sm badge badge-sm"
                                        :class="badgeClass(selectedStatus)"
                                        x-model="selectedStatus"
                                        @change="updateStatus()"
                                    >
                                        <option value="Active" :selected="selectedStatus === 'Active'">Active</option>
                                        <option value="On Leave" :selected="selectedStatus === 'On Leave'">On Leave</option>
                                        <option value="Suspended" :selected="selectedStatus === 'Suspended'">Suspended</option>
                                    </select>
                                </td>
                                <td>{{ $member->phone_number }}</td>
                                <td>{{ $member->email }}</td>
                                <td>
                                   
                                  {{--  <div class= "d inline">
                                        <button type="button" class="btn btn-sm btn-info edit-staff-btn"
                                          data-bs-toggle="modal"
                                          data-bs-target="#editStaffModal"
                                          data-id="{{ $member->id }}">
                                             Edit
                                         </button>--}}
                                    
                                    {{-- Delete Form --}}
                                    <form action="{{ route('staff_management.staff.destroy', $member->id) }}" method="POST" style="display: none;" id="delete-form-{{ $member->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDeleteStaff('{{ $member->id }}', '{{ $member->full_name }}')"><i class="fa-solid fa-trash"></i></button>
                                </div>
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
        </div>
     

            <!-- Work Assignment History Tab Content -->
            <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                @include('staff_management.Workassignment', [
                    'workAssignments' => $workAssignments, 
                    'staffMembersForDropdown' => $staffMembersForDropdown,
                    'workCenters' => $workCenters
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
    </div>

    {{-- Universal Session Messages  --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif
    @if(session('success_leave_history'))
        <div class="alert alert-success mt-3">{{ session('success_leave_history') }}</div>
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
    

            <!-- Add Staff Modal -->
            <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addStaffModalLabel">Add Staff</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addStaffForm" action="{{ route('staff_management.staff.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <h6>Staff details</h6>
                                <div class="text-center mb-4">
                                    <div class="profile-picture-container">
                                        <img id="addStaffProfilePreview" src="/assets/img/default-avatar.png" alt="Profile Picture Preview" class="rounded-circle profile-picture mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                                        <div class="mt-2">
                                            <label for="add_profile_picture" class="btn btn-sm btn-outline-primary">
                                                Upload Picture
                                            </label>
                                            <input type="file" id="add_profile_picture" name="profile_picture" class="d-none" accept="image/*" onchange="previewImage(this, 'addStaffProfilePreview')">
                                        </div>
                                    </div>
                                </div>
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

            <!-- Edit Staff Modal -->
           {{--   <div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editStaffForm" method="POST" enctype="multipart/form-data"> 
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_staff_id" name="id">
                                <h6>Staff details</h6>
                                <div class="text-center mb-4">
                                    <div class="profile-picture-container">
                                        <img id="editStaffProfilePreview" src="/assets/img/default-avatar.png" alt="Profile Picture Preview" class="rounded-circle profile-picture mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                                        <div class="mt-2">
                                            <label for="edit_profile_picture" class="btn btn-sm btn-outline-primary">
                                                Change Picture
                                            </label>
                                            <input type="file" id="edit_profile_picture" name="profile_picture" class="d-none" accept="image/*" onchange="previewImage(this, 'editStaffProfilePreview')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="edit_full_name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="edit_full_name" name="full_name" required>
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_role" class="form-label">Role</label>
                                        <select class="form-select @error('role') is-invalid @enderror" id="edit_role" name="role" required>
                                            <option value="">Select Role</option>
                                            <option value="Logistics Supervisor">Logistics Supervisor</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Warehouse Clerk">Warehouse Clerk</option>
                                            <option value="QA">QA</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    
                                        <label for="edit_status" class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="edit_status" name="status" required>
                                            <option value=""> Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Suspended">Suspended</option>
                                            <option value="On Leave">On Leave</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="edit_phone_number" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="edit_phone_number" name="phone_number" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="edit_email" name="email" required>
                                    @error('email')
                                        <div class="invalid-feedback" id="edit_email_error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Staff</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>--}}

    <!-- Staff Details Modal -->
<div class="modal fade" id="staffDetailsModal" tabindex="-1" aria-labelledby="staffDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staffDetailsModalLabel">Staff Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group" id="staffDetailsList">
          <!-- Details to be populated by JS -->
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Staff Tab related JavaScript
   /*  @if ($errors->any() && session('open_add_modal'))
        var addStaffModal = new bootstrap.Modal(document.getElementById('addStaffModal'));
        addStaffModal.show();
    @endif

    var editStaffModal = document.getElementById('editStaffModal');
    if (editStaffModal) { // Check if the modal exists within the current view
        let currentEditStaffId = null;
        const bootstrapModal = new bootstrap.Modal(editStaffModal);
        
        editStaffModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var staffId = button.getAttribute('data-id');
            currentEditStaffId = staffId;

            // Clear form first
            document.getElementById('edit_staff_id').value = '';
            document.getElementById('edit_full_name').value = '';
            document.getElementById('edit_role').value = '';
            document.getElementById('edit_status').value = '';
            document.getElementById('edit_phone_number').value = '';
            document.getElementById('edit_email').value = '';

            fetch('/staff-management/staff/' + staffId)
                .then(response => {
                    console.log('Response status:', response.status); // Debug log
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Staff data received:', data); // Debug log
                    document.getElementById('edit_staff_id').value = data.id || '';
                    document.getElementById('edit_full_name').value = data.full_name || '';
                    document.getElementById('edit_role').value = data.role || '';
                    document.getElementById('edit_status').value = data.status || '';
                    document.getElementById('edit_phone_number').value = data.phone_number || '';
                    document.getElementById('edit_email').value = data.email || '';

                    document.getElementById('editStaffForm').setAttribute('action', '/staff-management/staff/' + data.id);
                })
                .catch(error => {
                    console.error('Error fetching staff data:', error);
                    alert('Error loading staff data. Please try again.');
                });
        });

        // Handle modal hidden event to properly manage focus
        editStaffModal.addEventListener('hidden.bs.modal', function () {
            // Remove aria-hidden when modal is fully hidden
            editStaffModal.removeAttribute('aria-hidden');
        });

        // Handle modal shown event
        editStaffModal.addEventListener('shown.bs.modal', function () {
            // Focus the first input field when modal is fully shown
            document.getElementById('edit_full_name').focus();
        });

        // Ensure the form action is set before submit
        document.getElementById('editStaffForm').addEventListener('submit', function(e) {
            const form = this;
            // If action is not set or missing ID, prevent submit
            if (!form.action.match(/\/staff-management\/staff\/[0-9]+$/)) {
                e.preventDefault();
                if (currentEditStaffId) {
                    form.setAttribute('action', '/staff-management/staff/' + currentEditStaffId);
                    form.submit();
                } else {
                    alert('Staff ID missing. Please try again.');
                }
            }
        });
    } */

    // Work Assignment Tab related JavaScript
    const addWorkAssignForm = document.getElementById('addWorkAssignForm');
    const addWorkAssignmentModal = new bootstrap.Modal(document.getElementById('addWorkAssignmentModal'));

    addWorkAssignForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(addWorkAssignForm);

        try {
            const response = await fetch('{{ route('staff_management.workassignment.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error('Error:', errorData);
                alert('Error adding work assignment: ' + (errorData.message || 'Something went wrong'));
                return;
            }

            const result = await response.json();
            console.log('Success:', result);
            alert('Work assignment added successfully!');

            addWorkAssignmentModal.hide(); // Close the modal
            addWorkAssignForm.reset(); // Clear the form

            //  Reload the work assignment table
            loadWorkAssignments();

        } catch (error) {
            console.error('Fetch error:', error);
            alert('An unexpected error occurred.');
        }
    });

    // *** Function to load work assignments ***
    function loadWorkAssignments() {
        fetch('/staff_management/Workassignment') 
            .then(response => response.json())
            .then(data => {
                // Assuming 'data' is an array of work assignment objects
                const tableBody = document.querySelector('#work table tbody'); // Adjust selector if needed
                tableBody.innerHTML = ''; // Clear existing table rows

                data.forEach(assignment => {
                    const row = tableBody.insertRow();
                    row.insertCell().textContent = assignment.assignment_id;
                    row.insertCell().textContent = assignment.staff_name || assignment.staff_id;
                    row.insertCell().textContent = assignment.work_center;
                    row.insertCell().textContent = assignment.role;
                    row.insertCell().textContent = assignment.start_date;
                    row.insertCell().textContent = assignment.end_date || 'N/A';

                    // Add cells for edit/delete buttons 
                    const actionsCell = row.insertCell();
                    actionsCell.innerHTML = `
                        <button class="btn btn-sm btn-info edit-work-assignment-btn" data-id="${assignment.assignment_id}">Edit</button>
                        <form action="/staff-management/workassignment/${assignment.assignment_id}" method="POST" style="display: none;" id="delete-work-form-${assignment.assignment_id}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        <button class="btn btn-sm btn-danger" onclick="confirmDeleteWorkAssignment('${assignment.assignment_id}')"><i class="fa-solid fa-trash"></i></button>
                    `;
                });
            })
            .catch(error => console.error('Error loading work assignments:', error));
    }

    // *** Initial load of work assignments (when the tab is first opened) ***
    if (window.location.hash === '#work') { // Check if the URL hash is #work
        loadWorkAssignments();
    }

    // *** Event listener for tab change (to load data when the tab is clicked) ***
    document.getElementById('work-tab').addEventListener('click', () => {
        loadWorkAssignments();
    });
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

    // Delegated event handler for dynamically loaded work assignment edit buttons
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('edit-work-assignment-btn')) {
            const assignmentId = event.target.getAttribute('data-id');
            fetch('/staff-management/workassignment/' + assignmentId)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(function(data) {
                    document.getElementById('edit_wa_id').value = data.assignment_id;
                    document.getElementById('edit_wa_staff_id').value = data.staff_id;
                    document.getElementById('edit_wa_role').value = data.role;
                    document.getElementById('edit_wa_start_date').value = data.start_date;
                    document.getElementById('edit_wa_end_date').value = data.end_date;
                    if(document.getElementById('edit_wa_status'))
                        document.getElementById('edit_wa_status').value = data.status || '';
                    if(document.getElementById('edit_wa_description'))
                        document.getElementById('edit_wa_description').value = data.description || '';
                    document.getElementById('editWorkAssignmentForm').setAttribute('action', '/staff-management/workassignment/' + data.assignment_id);
                    var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editWorkAssignmentModal'));
                    modal.show();
                })
                .catch(error => {
                    alert('Failed to load assignment data.');
                    console.error(error);
                });
        }
        // Delegated event handler for leave history edit buttons
        if (event.target.classList.contains('edit-leave-record-btn')) {
            const leaveId = event.target.getAttribute('data-id');
            fetch('/staff-management/leavehistory/' + leaveId)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(function(data) {
                    document.getElementById('edit_lh_id').value = data.leave_id || data.id;
                    document.getElementById('edit_lh_staff_id').value = data.staff_id;
                    document.getElementById('edit_lh_leave_type').value = data.leave_type;
                    document.getElementById('edit_lh_start_date').value = data.start_date;
                    document.getElementById('edit_lh_end_date').value = data.end_date;
                    document.getElementById('edit_lh_status').value = data.status;
                    document.getElementById('editLeaveRecordForm').setAttribute('action', '/staff-management/leavehistory/' + (data.leave_id || data.id));
                    var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editLeaveRecordModal'));
                    modal.show();
                })
                .catch(error => {
                    alert('Failed to load leave record data.');
                    console.error(error);
                });
        }
    });

    // Staff row click handler for details modal (event delegation for dynamic rows)
    document.addEventListener('click', function(e) {
        const row = e.target.closest('.staff-row');
        if (row && !e.target.closest('button,form')) {
            const staffId = row.getAttribute('data-id');
            fetch('/staff-management/staff/' + staffId)
                .then(response => response.json())
                .then(data => {
                    const details = [
                        {label: 'Staff ID', value: data.id},
                        {label: 'Full Name', value: data.full_name},
                        {label: 'Work Center', value: data.work_center},
                        {label: 'Role', value: data.role},
                        {label: 'Status', value: data.status},
                        {label: 'Phone Number', value: data.phone_number},
                        {label: 'Email', value: data.email}
                    ];
                    const list = document.getElementById('staffDetailsList');
                    list.innerHTML = '';
                    details.forEach(item => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item';
                        li.innerHTML = `<strong>${item.label}:</strong> ${item.value}`;
                        list.appendChild(li);
                    });
                    var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('staffDetailsModal'));
                    modal.show();
                });
        }
    });
 });


{{-- SweetAlert2 Delete Modal --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeleteStaff(staffId, staffName) {
    Swal.fire({
        title: 'Confirm Deletion',
        text: `Are you sure you want to delete ${staffName}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + staffId).submit();
        }
    });
}
function confirmDeleteWorkAssignment(assignmentId) {
    Swal.fire({
        title: 'Confirm Deletion',
        text: 'Are you sure you want to delete this work assignment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-work-form-' + assignmentId).submit();
        }
    });
}
function confirmDeleteLeaveHistory(leaveId) {
    Swal.fire({
        title: 'Confirm Deletion',
        text: 'Are you sure you want to delete this leave record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-leave-form-' + leaveId).submit();
        }
    });
}
</script>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
// Alpine.js global event listener for staff status change
if (window.Alpine) {
    document.addEventListener('alpine:init', () => {
        Alpine.data('statusDropdown', () => ({
            init() {
                this.$watch('selectedStatus', value => {
                    // No-op: handled by event below
                });
            }
        }));
    });
}

// Listen for statusChanged event (from Alpine or vanilla JS)
document.addEventListener('statusChanged', function(e) {
    const staffId = e.detail.id;
    const newStatus = e.detail.status;
    const url = `/staff-management/staff/${staffId}/status`;
    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update badge color
            const row = document.querySelector(`tr[data-id='${staffId}']`);
            if (row) {
                const select = row.querySelector('select');
                select.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-secondary');
                if (newStatus === 'Active') select.classList.add('bg-success');
                else if (newStatus === 'Suspended') select.classList.add('bg-danger');
                else if (newStatus === 'On Leave') select.classList.add('bg-warning');
                else select.classList.add('bg-secondary');
            }
            // Optional: show toast/alert
            if (window.Swal) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Status updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                alert('Status updated successfully!');
            }
        } else {
            throw new Error(data.message || 'Update failed');
        }
    })
    .catch(err => {
        if (window.Swal) {
            Swal.fire('Error', err.message, 'error');
        } else {
            alert('Failed to update status: ' + err.message);
        }
    });
});

// Add this function to the script section so it is defined for Alpine
function updateAbsentStaffCard() {
    const selects = document.querySelectorAll('tr.staff-row select');
    let absentCount = 0;
    selects.forEach(sel => {
        if (sel.value === 'On Leave') absentCount++;
    });
    const absentCard = document.querySelector('.absent-staff-card .main-number');
    if (absentCard) {
        absentCard.textContent = absentCount;
    }
}
</script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailsPanel = document.getElementById('staffDetailsPanel');
    const closeButton = document.getElementById('closeStaffDetails');
    let currentStaffId = null;

    // Handle row click to show staff details
    document.querySelectorAll('.staff-row').forEach(row => {
        row.addEventListener('click', async function() {
            const staffId = this.dataset.id;
            currentStaffId = staffId;
            
            try {
                const response = await fetch(`/staff-management/staff/${staffId}`);
                if (!response.ok) throw new Error('Failed to fetch staff details');
                
                const staff = await response.json();
                
                // Update panel content
                document.querySelector('.staff-name').textContent = staff.full_name;
                document.querySelector('.staff-id').textContent = staff.id;
                document.querySelector('.staff-role').textContent = staff.role;
                document.querySelector('.staff-status').textContent = staff.status;
                document.querySelector('.staff-phone').textContent = staff.phone_number;
                document.querySelector('.staff-email').textContent = staff.email;
                
                // Update profile picture
                const profilePicture = document.getElementById('staffProfilePicture');
                profilePicture.src = staff.profile_picture_url || '/assets/img/default-avatar.png';
                
                // Show panel
                detailsPanel.classList.remove('d-none');
            } catch (error) {
                console.error('Error fetching staff details:', error);
                alert('Failed to load staff details');
            }
        });
    });

    // Handle profile picture upload
    const profilePictureInput = document.getElementById('profilePictureInput');
    profilePictureInput.addEventListener('change', async function() {
        if (!currentStaffId) return;
        
        const formData = new FormData();
        formData.append('profile_picture', this.files[0]);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        try {
            const response = await fetch(`/staff-management/staff/${currentStaffId}/profile-picture`, {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) throw new Error('Failed to upload profile picture');
            
            const result = await response.json();
            if (result.success) {
                document.getElementById('staffProfilePicture').src = result.profile_picture_url;
                if (window.Swal) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Profile picture updated successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    alert('Profile picture updated successfully');
                }
            }
        } catch (error) {
            console.error('Error uploading profile picture:', error);
            alert('Failed to update profile picture');
        }
    });

    // Handle close button click
    closeButton.addEventListener('click', function() {
        detailsPanel.classList.add('d-none');
        currentStaffId = null;
    });

    // Close panel when clicking outside
    document.addEventListener('click', function(event) {
        if (!detailsPanel.contains(event.target) && 
            !event.target.closest('.staff-row') && 
            !detailsPanel.classList.contains('d-none')) {
            detailsPanel.classList.add('d-none');
            currentStaffId = null;
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    #staffDetailsPanel {
        background: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .staff-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .staff-row:hover {
        background-color: #f8f9fa;
    }

    #profilePicturePreview {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #eee;
    }

    .staff-details-content {
        min-height: 300px;
    }

    .staff-details-panel {
    position: fixed;
    top: 0;
    right: 0;
    width: 350px;
    height: 100vh;
    background: #fff;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1040;
    overflow-y: auto;
    transition: transform 0.3s ease-in-out;
}

.staff-details-panel.d-none {
    transform: translateX(100%);
}

.profile-picture-container {
    position: relative;
    display: inline-block;
}

.profile-picture {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.info-row {
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #eee;
}

.info-label {
    font-weight: bold;
    color: #666;
    display: inline-block;
    width: 80px;
}
</style>
@endpush
