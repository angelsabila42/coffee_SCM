<div class="container py-4">
    <h2 class="mb-4">Transporter Delivery Dashboard</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Active Deliveries</h5>
                    <p class="display-4">{{ $activeDeliveries }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pending Deliveries</h5>
                    <p class="display-4">{{ $pendingDeliveries }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <p class="display-4">{{ $completedDeliveries }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Delayed</h5>
                    <p class="display-4">{{ $delayedDeliveries }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Current Deliveries</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>DeliveryID</th>
                        <th>Coffee Type</th>
                        <th>Quantity</th>
                        <th>Pickup</th>
                        <th>Status</th>
                        <th>ETA</th>
                        <th>Date Ordered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($currentDeliveries as $delivery)
                        <tr>
                            <td>{{ $delivery->delivery_id }}</td>
                            <td>{{ $delivery->coffee_type }}</td>
                            <td>{{ $delivery->quantity }}</td>
                            <td>{{ $delivery->pickup_location }}</td>
                            <td>{{ $delivery->status }}</td>
                            <td>{{ $delivery->eta }}</td>
                            <td>{{ $delivery->date_ordered }}</td>
                            <td><!-- Actions here --></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Delivery Requests</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>DeliveryID</th>
                        <th>Coffee Type</th>
                        <th>Quantity</th>
                        <th>Pickup</th>
                        <th>Status</th>
                        <th>ETA</th>
                        <th>Date Ordered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryRequests as $delivery)
                        <tr>
                            <td>{{ $delivery->delivery_id }}</td>
                            <td>{{ $delivery->coffee_type }}</td>
                            <td>{{ $delivery->quantity }}</td>
                            <td>{{ $delivery->pickup_location }}</td>
                            <td>{{ $delivery->status }}</td>
                            <td>{{ $delivery->eta }}</td>
                            <td>{{ $delivery->date_ordered }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" wire:click="accept({{ $delivery->id }})">Accept</button>
                                <button class="btn btn-danger btn-sm" wire:click="decline({{ $delivery->id }})">Decline</button>
                                <button class="btn btn-info btn-sm" wire:click="downloadSummary({{ $delivery->id }})">Download</button>
                                <button class="btn btn-primary btn-sm" wire:click="showAssignDriverModal({{ $delivery->id }})">Assign Driver</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($showAssignDriverModal)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Driver</h5>
                <button type="button" class="close" wire:click="closeAssignDriverModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Assign Driver</label>
                    <select class="form-control" wire:model="selectedDriver">
                        <option value="">Select Driver</option>
                        @foreach($driverList as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label>Enter Details, if not found</label>
                    <input type="text" class="form-control" wire:model="manualDriverName" placeholder="Full Name">
                </div>
                <div class="form-group mt-2">
                    <label>ETA</label>
                    <input type="date" class="form-control" wire:model="eta">
                </div>
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" wire:model="sendEmail" id="sendEmail">
                    <label class="form-check-label" for="sendEmail">Send email confirmation</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" wire:click="assignDriver">Assign</button>
                <button class="btn btn-secondary" wire:click="closeAssignDriverModal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endif 