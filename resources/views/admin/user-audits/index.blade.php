@extends('layouts.app')



@section('sidebar-items')
    @include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style=" font-weight: 700;">User Audit Logs</h2>
       
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-black" style=" border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0" style="color: #0f0c0aff;">{{ $stats['total_logins'] }}</h4>
                            <p class="mb-0" style="color: #030201ff;">Total Logins</p>
                        </div>
                        <i class="bx bx-log-in" style="font-size: 2.5rem; opacity: 0.7; color: #8B4513;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style=" border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0" style="color: #150c06ff;">{{ $stats['total_logouts'] }}</h4>
                            <p class="mb-0" style="color: #070301ff;">Total Logouts</p>
                        </div>
                        <i class="bx bx-log-out" style="font-size: 2.5rem; opacity: 0.7; color: #22126dff;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style=" border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0" style="color: #120904ff;">{{ $stats['unique_users'] }}</h4>
                            <p class="mb-0" style="color: #170b02ff;">Unique Users</p>
                        </div>
                        <i class="bx bx-user" style="font-size: 2.5rem; opacity: 0.7; color: #8b4513ff;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style=" border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0" style="color: #1b0e04ff;">{{ $stats['today_logins'] }}</h4>
                            <p class="mb-0" style="color: #120902ff;">Today's Logins</p>
                        </div>
                        <i class="fa-solid fa-calendar-days" style="font-size: 2.5rem; opacity: 0.7; color: #187e36ff;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); ">
        <div class="card-header" style=" color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="fa-solid fa-filter"></i>
            </h5>
        </div>
        <div class="card-body" >
            <form method="GET" action="{{ route('admin.user-audits.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user_id" style=" font-weight: 600;">User</label>
                            <select name="user_id" id="user_id" class="form-control" style="border: 2px solid ; border-radius: 8px; background-color: #FEFEFE;">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="activity_type"  style= " font-weight: 600;">Activity Type</label>
                            <select name="activity_type" id="activity_type" class="form-control" style="border: 2px solid; border-radius: 8px; background-color: #FEFEFE;">
                                <option value="">All Activities</option>
                                <option value="login" {{ request('activity_type') == 'login' ? 'selected' : '' }}>Login</option>
                                <option value="logout" {{ request('activity_type') == 'logout' ? 'selected' : '' }}>Logout</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_from" style=" font-weight: 600;">From Date</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}" style="border: 2px solid ; border-radius: 8px; background-color: #FEFEFE;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_to" style="font-weight: 600;">To Date</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}" style="border: 2px solid; border-radius: 8px; background-color: #FEFEFE;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label style="color: #8B4513; font-weight: 600;">&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn mr-2" style="background-color: #9b9997ff; color: white; border-radius: 20px;">
                                    <i class="bx bx-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.user-audits.index') }}" class="btn" style="background-color: #7b7a7aff; color: white; border-radius: 20px;">
                                    <i class="bx bx-refresh"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); ">
        <div class="card-header" style=" color: black; border-radius: 10px 10px 0 0;">
           
        </div>
        <div class="card-body" >
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead >
                        <tr>
                            <th >Date & Time</th>
                            <th >User</th>
                            <th >Role</th>
                            <th >Activity</th>
                            <th >IP Address</th>
                            <th >Session Duration</th>
                            <th >Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($activity->created_at)->format('M d, Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($activity->created_at)->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                         style="width: 32px; height: 32px; color: black; font-size: 12px;">
                                        {{ strtoupper(substr($activity->user->name ?? 'N/A', 0, 2)) }}
                                    </div>
                                    <span style="font-weight: 600;">{{ $activity->user->name ?? 'Unknown User' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background-color: 
                                    @if(($activity->user->role ?? '') == 'admin') #dc3545 
                                    @elseif(($activity->user->role ?? '') == 'importer') #007bff 
                                    @elseif(($activity->user->role ?? '') == 'transporter') #28a745 
                                    @else #6c757d @endif; color: white;">
                                    {{ ucfirst($activity->user->role ?? 'Unknown') }}
                                </span>
                            </td>
                            <td>
                                @if($activity->type == 'login')
                                    <span class="badge badge-success">
                                        <i class="bx bx-log-in"></i> Login
                                    </span>
                                @elseif($activity->type == 'logout')
                                    <span class="badge badge-danger">
                                        <i class="bx bx-log-out"></i> Logout
                                    </span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($activity->type) }}</span>
                                @endif
                            </td>
                            <td>
                                <code style="background-color: #f8f9fa; padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                                    {{ $activity->ip_address ?? 'N/A' }}
                                </code>
                            </td>
                            <td>
                                @if($activity->data && isset($activity->data['session_duration']))
                                    <span class="text-info">{{ $activity->data['session_duration'] }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="viewActivityDetails({{ $activity->id }})" style="border-radius: 15px;">
                                    <i class="bx bx-show"></i> View
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No audit logs found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $activities->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Activity Details Modal -->
<div class="modal fade" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="activityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 10px;">
            <div class="modal-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                <h5 class="modal-title" id="activityModalLabel">
                    <i class="bx bx-info-circle"></i> Activity Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="activityDetails" style="background-color: #F5F5DC;">
                <!-- Activity details will be loaded here -->
            </div>
            <div class="modal-footer" >
                <button type="button" class="btn" data-dismiss="modal" 
                        style=" color: black; border-radius: 20px;">
                    <i class="bx bx-x"></i> Close
                </button>
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

.modal-content {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-control:focus {
    border-color: #8B4513 !important;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25) !important;
}
</style>
@endsection

@section('scripts')
<script>
// Set up CSRF token for all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function viewActivityDetails(activityId) {
    // Show loading in modal
    document.getElementById('activityDetails').innerHTML = '<div class="text-center py-4"><i class="bx bx-loader-alt bx-spin" style="font-size: 2rem; color: #8B4513;"></i><br><span style="color: #8B4513;">Loading activity details...</span></div>';
    
    // Show modal
    $('#activityModal').modal('show');
    
    // Fetch activity details
    fetch('/admin/user-audits/' + activityId, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const activity = data.activity;
            const activityData = activity.data || {};
            
            document.getElementById('activityDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 style="color: #8B4513; border-bottom: 2px solid #F5F5DC; padding-bottom: 5px;">Basic Information</h6>
                        <p><strong>User:</strong> ${activity.user ? activity.user.name : 'Unknown User'}</p>
                        <p><strong>Email:</strong> ${activity.user ? activity.user.email : 'N/A'}</p>
                        <p><strong>Role:</strong> ${activity.user ? activity.user.role : 'N/A'}</p>
                        <p><strong>Activity Type:</strong> ${activity.type}</p>
                        <p><strong>Title:</strong> ${activity.title || 'N/A'}</p>
                        <p><strong>Date & Time:</strong> ${new Date(activity.created_at).toLocaleString()}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 style="color: #8B4513; border-bottom: 2px solid #F5F5DC; padding-bottom: 5px;">Technical Details</h6>
                        <p><strong>IP Address:</strong> ${activity.ip_address || 'N/A'}</p>
                        <p><strong>Session Duration:</strong> ${activityData.session_duration || 'N/A'}</p>
                        <p><strong>Browser:</strong> ${activityData.user_agent ? activityData.user_agent.substring(0, 50) + '...' : 'N/A'}</p>
                        <p><strong>Platform:</strong> ${activityData.platform || 'N/A'}</p>
                        <p><strong>Device:</strong> ${activityData.device || 'N/A'}</p>
                        <p><strong>Login Time:</strong> ${activityData.login_time || 'N/A'}</p>
                    </div>
                </div>
                ${Object.keys(activityData).length > 0 ? `
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 style="color: #8B4513; border-bottom: 2px solid #F5F5DC; padding-bottom: 5px;">Raw Data</h6>
                        <pre style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; font-size: 12px; max-height: 200px; overflow-y: auto;">${JSON.stringify(activityData, null, 2)}</pre>
                    </div>
                </div>
                ` : ''}
            `;
        } else {
            document.getElementById('activityDetails').innerHTML = '<div class="text-center py-4 text-danger">Failed to load activity details.</div>';
        }
    })
    .catch(error => {
        document.getElementById('activityDetails').innerHTML = '<div class="text-center py-4 text-danger">Error loading activity details.</div>';
        console.error('Error:', error);
    });
}

// Auto-refresh page every 30 seconds
setTimeout(function() {
    window.location.reload();
}, 30000);
</script>
@endsection
