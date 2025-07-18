@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">Delivery Management</h2>
        <div>
            <button class="btn" onclick="window.location.reload()" style="background-color: #8B4513; color: white; border-radius: 20px;">
                <i class="bx bx-refresh"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #CD853F, #D2691E); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $pendingConfirmation ?? 0 }}</h4>
                            <p class="mb-0">Pending Confirmation</p>
                        </div>
                        <i class="bx bx-clock-alt" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #8B4513, #A0522D); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $confirmed ?? 0 }}</h4>
                            <p class="mb-0">Confirmed Deliveries</p>
                        </div>
                        <i class="bx bx-check-circle" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #A0522D, #CD853F); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $inTransit ?? 0 }}</h4>
                            <p class="mb-0">In Transit</p>
                        </div>
                        <i class="bx bx-truck" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #6B4423, #8B4513); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $needsDriver ?? 0 }}</h4>
                            <p class="mb-0">Needs Driver</p>
                        </div>
                        <i class="bx bx-user-plus" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmed Deliveries (Admin Approved) -->
    <div class="card mb-4" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-check-circle"></i> Confirmed Deliveries - Assign Drivers
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead style="background-color: #F5F5DC;">
                        <tr>
                            <th style="color: #8B4513;">Delivery ID</th>
                            <th style="color: #8B4513;">Coffee Type</th>
                            <th style="color: #8B4513;">Quantity</th>
                            <th style="color: #8B4513;">Destination</th>
                            <th style="color: #8B4513;">Pickup Location</th>
                            <th style="color: #8B4513;">Status</th>
                            <th style="color: #8B4513;">Driver</th>
                            <th style="color: #8B4513;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($confirmedDeliveries as $delivery)
                        <tr>
                            <td><strong>{{ $delivery->delivery_id }}</strong></td>
                            <td>{{ $delivery->coffee_type }}</td>
                            <td>{{ $delivery->quantity }} kg</td>
                            <td>{{ $delivery->delivery_destination }}</td>
                            <td>{{ $delivery->pickup_location ?? 'TBD' }}</td>
                            <td>
                                <span class="badge badge-success">{{ $delivery->status }}</span>
                            </td>
                            <td>
                                @if($delivery->assigned_driver)
                                    <span class="badge badge-info">{{ $delivery->assigned_driver }}</span>
                                @else
                                    <span class="badge badge-warning">Not Assigned</span>
                                @endif
                            </td>
                            <td>
                                @if(!$delivery->assigned_driver || $delivery->assigned_driver == '')
                                    <button class="btn btn-sm" onclick="openDriverModal({{ $delivery->id }}, '{{ $delivery->delivery_id }}')" 
                                            style="background-color: #8B4513; color: white; border-radius: 15px;">
                                        <i class="bx bx-user-plus"></i> Assign Driver
                                    </button>
                                @else
                                    <button class="btn btn-sm" onclick="openDriverModal({{ $delivery->id }}, '{{ $delivery->delivery_id }}')"
                                            style="background-color: #A0522D; color: white; border-radius: 15px;">
                                        <i class="bx bx-edit"></i> Assign Driver
                                    </button>
                                @endif
                                <a href="#" class="btn btn-sm" onclick="viewDelivery({{ $delivery->id }})" 
                                   style="background-color: #CD853F; color: white; border-radius: 15px;">
                                    <i class="bx bx-show"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No confirmed deliveries available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Deliveries -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-truck"></i> Active Deliveries - In Progress
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead style="background-color: #F5F5DC;">
                        <tr>
                            <th style="color: #8B4513;">Delivery ID</th>
                            <th style="color: #8B4513;">Coffee Type</th>
                            <th style="color: #8B4513;">Quantity</th>
                            <th style="color: #8B4513;">Destination</th>
                            <th style="color: #8B4513;">Driver</th>
                            <th style="color: #8B4513;">ETA</th>
                            <th style="color: #8B4513;">Status</th>
                            <th style="color: #8B4513;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeDeliveries as $delivery)
                        <tr>
                            <td><strong>{{ $delivery->delivery_id }}</strong></td>
                            <td>{{ $delivery->coffee_type }}</td>
                            <td>{{ $delivery->quantity }} kg</td>
                            <td>{{ $delivery->delivery_destination }}</td>
                            <td>
                                <span class="badge" style="background-color: #8B4513; color: white;">{{ $delivery->assigned_driver }}</span>
                            </td>
                            <td>{{ $delivery->eta ? \Carbon\Carbon::parse($delivery->eta)->format('M d, Y') : 'Not set' }}</td>
                            <td>
                                <span class="badge badge-warning">{{ $delivery->status }}</span>
                            </td>
                            <td>
                                <button class="btn btn-sm" onclick="markDelivered({{ $delivery->id }})"
                                        style="background-color: #228B22; color: white; border-radius: 15px;">
                                    <i class="bx bx-check"></i> Mark Delivered
                                </button>
                                <button class="btn btn-sm" onclick="openDriverModal({{ $delivery->id }}, '{{ $delivery->delivery_id }}')"
                                        style="background-color: #A0522D; color: white; border-radius: 15px;">
                                    <i class="bx bx-edit"></i> Assign Driver
                                </button>
                                <a href="#" class="btn btn-sm" onclick="viewDelivery({{ $delivery->id }})"
                                   style="background-color: #CD853F; color: white; border-radius: 15px;">
                                    <i class="bx bx-show"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No active deliveries</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Driver Assignment Modal -->
<div class="modal fade" id="driverModal" tabindex="-1" role="dialog" aria-labelledby="driverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 10px;">
            <div class="modal-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                <h5 class="modal-title" id="driverModalLabel">
                    <i class="bx bx-user-plus"></i> Assign Driver to Delivery
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignDriverForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="background-color: #FAFAFA;">
                    <div class="form-group mb-3">
                        <label style="color: #8B4513; font-weight: 600;">Delivery ID</label>
                        <input type="text" class="form-control" id="modalDeliveryId" readonly 
                               style="border: 2px solid #F5F5DC; border-radius: 8px; background-color: #F5F5DC;">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label style="color: #8B4513; font-weight: 600;">Select Driver <span class="text-danger">*</span></label>
                        <select name="driver_id" id="driverSelect" class="form-control" 
                                style="border: 2px solid #F5F5DC; border-radius: 8px;">
                            <option value="">Choose a driver...</option>
                            @foreach($availableDrivers as $driver)
                                <option value="{{ $driver->id }}">
                                    {{ $driver->name }} 
                                    @if($driver->license_number)
                                        - License: {{ $driver->license_number }}
                                    @endif
                                    @if($driver->vehicle_number)
                                        - Vehicle: {{ $driver->vehicle_number }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label style="color: #8B4513; font-weight: 600;">Or Enter Driver Name Manually</label>
                        <input type="text" name="manual_driver_name" class="form-control" 
                               placeholder="Driver name if not in list above"
                               style="border: 2px solid #F5F5DC; border-radius: 8px;">
                        <small class="text-muted">Use this if the driver is not registered in the system</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Estimated Time of Arrival</label>
                                <input type="datetime-local" name="eta" class="form-control"
                                       style="border: 2px solid #F5F5DC; border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label style="color: #8B4513; font-weight: 600;">Pickup Location</label>
                                <input type="text" name="pickup_location" class="form-control" 
                                       placeholder="Where to pick up the coffee"
                                       style="border: 2px solid #F5F5DC; border-radius: 8px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #F5F5DC;">
                    <button type="button" class="btn" data-dismiss="modal" 
                            style="background-color: #A0522D; color: white; border-radius: 20px;">
                        <i class="bx bx-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn" 
                            style="background-color: #8B4513; color: white; border-radius: 20px;">
                        <i class="bx bx-check"></i> Assign Driver
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delivery Details Modal -->
<div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog" aria-labelledby="deliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 10px;">
            <div class="modal-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                <h5 class="modal-title" id="deliveryModalLabel">
                    <i class="bx bx-package"></i> Delivery Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="deliveryDetails" style="background-color: #FAFAFA;">
                <!-- Delivery details will be loaded here -->
            </div>
            <div class="modal-footer" style="background-color: #F5F5DC;">
                <button type="button" class="btn" data-dismiss="modal" 
                        style="background-color: #8B4513; color: white; border-radius: 20px;">
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

// Wait for DOM to be fully loaded
$(document).ready(function() {
    console.log('Deliveries page loaded and jQuery ready');
});

function openDriverModal(deliveryId, deliveryIdText) {
    document.getElementById('modalDeliveryId').value = deliveryIdText;
    document.getElementById('assignDriverForm').action = '/transporter/deliveries/' + deliveryId + '/assign-driver';
    
    // Clear previous selections
    document.getElementById('driverSelect').value = '';
    document.querySelector('input[name="manual_driver_name"]').value = '';
    document.querySelector('input[name="eta"]').value = '';
    document.querySelector('input[name="pickup_location"]').value = '';
    
    // Show modal using Bootstrap 5 syntax
    const modal = new bootstrap.Modal(document.getElementById('driverModal'));
    modal.show();
}

function markDelivered(deliveryId) {
    // Show confirmation dialog
    if (confirm('Are you sure you want to mark this delivery as completed? This action cannot be undone.')) {
        // Show loading state
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Processing...';
        button.disabled = true;
        
        fetch('/transporter/deliveries/' + deliveryId + '/mark-delivered', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification('Success!', 'Delivery marked as completed successfully.', 'success');
                // Reload page after short delay
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                // Restore button state
                button.innerHTML = originalText;
                button.disabled = false;
                showNotification('Error!', data.message || 'Failed to mark delivery as completed.', 'error');
            }
        })
        .catch(error => {
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
            showNotification('Error!', 'Network error occurred. Please try again.', 'error');
            console.error('Error:', error);
        });
    }
}

function viewDelivery(deliveryId) {
    // Show loading in modal
    document.getElementById('deliveryDetails').innerHTML = '<div class="text-center py-4"><i class="bx bx-loader-alt bx-spin" style="font-size: 2rem; color: #8B4513;"></i><br><span style="color: #8B4513;">Loading delivery details...</span></div>';
    
    // Show modal using Bootstrap 5 syntax
    const modal = new bootstrap.Modal(document.getElementById('deliveryModal'));
    modal.show();
    
    // Fetch delivery details
    fetch('/transporter/deliveries/' + deliveryId + '/details', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const delivery = data.delivery;
            document.getElementById('deliveryDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 style="color: #8B4513; border-bottom: 2px solid #F5F5DC; padding-bottom: 5px;">Delivery Information</h6>
                        <p><strong>Delivery ID:</strong> ${delivery.delivery_id || 'N/A'}</p>
                        <p><strong>Coffee Type:</strong> ${delivery.coffee_type || 'N/A'}</p>
                        <p><strong>Quantity:</strong> ${delivery.quantity || 'N/A'} kg</p>
                        <p><strong>Grade:</strong> ${delivery.coffee_grade || 'N/A'}</p>
                        <p><strong>Status:</strong> <span class="badge" style="background-color: #8B4513; color: white;">${delivery.status || 'N/A'}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 style="color: #8B4513; border-bottom: 2px solid #F5F5DC; padding-bottom: 5px;">Location & Driver</h6>
                        <p><strong>Pickup Location:</strong> ${delivery.pickup_location || 'Not set'}</p>
                        <p><strong>Destination:</strong> ${delivery.delivery_destination || 'N/A'}</p>
                        <p><strong>Assigned Driver:</strong> ${delivery.assigned_driver || 'Not assigned'}</p>
                        <p><strong>ETA:</strong> ${delivery.eta ? new Date(delivery.eta).toLocaleDateString() : 'Not set'}</p>
                        <p><strong>Date Ordered:</strong> ${delivery.created_at ? new Date(delivery.created_at).toLocaleDateString() : 'N/A'}</p>
                    </div>
                </div>
            `;
        } else {
            document.getElementById('deliveryDetails').innerHTML = '<div class="text-center py-4 text-danger">Failed to load delivery details.</div>';
        }
    })
    .catch(error => {
        document.getElementById('deliveryDetails').innerHTML = '<div class="text-center py-4 text-danger">Error loading delivery details.</div>';
        console.error('Error:', error);
    });
}

function showNotification(title, message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 10px;';
    notification.innerHTML = `
        <strong>${title}</strong> ${message}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

// Form validation for driver assignment
document.getElementById('assignDriverForm').addEventListener('submit', function(e) {
    const driverSelect = document.getElementById('driverSelect').value;
    const manualDriverName = document.querySelector('input[name="manual_driver_name"]').value;
    
    if (!driverSelect && !manualDriverName.trim()) {
        e.preventDefault();
        showNotification('Validation Error', 'Please select a driver from the list or enter a driver name manually.', 'error');
        return false;
    }
});
</script>
@endsection
