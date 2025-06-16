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

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWorkAssignModal">
    Add Work Assignment
</button>

<div class="modal fade" id="addWorkAssignModal" tabindex="-1" aria-labelledby="addWorkAssignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWorkAssignModalLabel">Add Work Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addWorkAssignForm" action="{{ route('work_assignment.store') }}" method="POST">
                    @csrf

                    <h6>Work Assignment History</h6>
                     <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="staff_id" class="form-label">Staff ID</label>
                            <input type="text" class="form-control" id="staff_id" name="staff_id" required>
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
                     </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                    </div>
                     
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="Logistics">Logistics</option>
                                <option value="Production">Production</option>
                                <option value="Quality Assurance">Quality Assurance</option>
                                <option value="QA">QA</option>
                            </select>
                        </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                          <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Assignment ID</th>
            <th>Staff ID</th>
            <th>Full Name</th>
            <th>Work Center</th>
            <th>Role</th>
            <th>Start Date</th>
            <th>End Date</th>
    </thead>
     <tbody>
         @forelse ($workAssignments as $assignment)
            <tr>
               <td>{{ $assignment->assignment_id }}</td>
               <td>{{ $assignment->staff->full_name ?? $assignment->staff_name }}</td> {{-- Use relationship if available, else denormalized --}}
               <td>{{ $assignment->center_name }}</td>
               <td>{{ $assignment->role }}</td>
               <td>{{ $assignment->start_date }}</td>
               <td>{{ $assignment->end_date }}</td>
                 <td>
                  <button type="button" class="btn btn-sm btn-info edit-work-assignment"
                        data-bs-toggle="modal" data-bs-target="#editWorkAssignmentModal"
                        data-id="{{ $assignment->id }}">
                             Edit
                      </button>
                   <form action="{{ route('staff_management.work-assignments.destroy', $assignment->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                       <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this assignment?')">Delete</button>
                      </form>
                       </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No work assignments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
