@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.transporter')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4" style="color: #8B4513;">Transporter Dashboard</h2>
            
            <!-- Dashboard Stats Cards -->
            <div class="row mb-4">
                <!-- Active Deliveries -->
                <div class="col-md-3 mb-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #8B4513, #A0522D);">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-0">{{ $activeDeliveries }}</h3>
                                    <p class="mb-0">Active Deliveries</p>
                                </div>
                                <div class="stats-icon">
                                    <i class='bx bx-truck' style="font-size: 3rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pending Deliveries -->
                <div class="col-md-3 mb-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #CD853F, #D2691E);">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-0">{{ $pendingDeliveries }}</h3>
                                    <p class="mb-0">Pending Deliveries</p>
                                </div>
                                <div class="stats-icon">
                                    <i class='bx bx-time' style="font-size: 3rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Completed -->
                <div class="col-md-3 mb-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #6B4423, #8B4513);">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-0">{{ $completedDeliveries }}</h3>
                                    <p class="mb-0">Completed</p>
                                </div>
                                <div class="stats-icon">
                                    <i class='bx bx-check-circle' style="font-size: 3rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Delayed -->
                <div class="col-md-3 mb-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #A0522D, #CD853F);">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-0">{{ $delayedDeliveries }}</h3>
                                    <p class="mb-0">Delayed</p>
                                </div>
                                <div class="stats-icon">
                                    <i class='bx bx-error-circle' style="font-size: 3rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Deliveries Table -->
            <div class="card">
                <div class="card-header" style="background-color: #8B4513; color: white;">
                    <h5 class="mb-0">
                        <i class='bx bx-list-ul'></i> Current Deliveries
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead style="background-color: #F5F5DC;">
                                <tr>
                                    <th>DeliveryID</th>
                                    <th>Coffee Type</th>
                                    <th>Quantity</th>
                                    <th>Pick up point</th>
                                    <th>Destination</th>
                                    <th>Status</th>
                                    <th>Date Ordered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($currentDeliveries as $delivery)
                                <tr>
                                    <td><strong>{{ $delivery->delivery_id ?? 'DL_' . $delivery->id }}</strong></td>
                                    <td>{{ $delivery->coffee_type ?? 'N/A' }}</td>
                                    <td>{{ $delivery->quantity ?? 'N/A' }} kg</td>
                                    <td>{{ $delivery->pickup_location ?? $delivery->origin ?? 'N/A' }}</td>
                                    <td>{{ $delivery->destination ?? 'N/A' }}</td>
                                    <td>
                                        @if($delivery->status == 'Confirmed')
                                            <span class="badge" style="background-color: #8B4513; color: white;">{{ $delivery->status }}</span>
                                        @elseif($delivery->status == 'In Transit')
                                            <span class="badge" style="background-color: #CD853F; color: white;">{{ $delivery->status }}</span>
                                        @elseif($delivery->status == 'Accepted')
                                            <span class="badge" style="background-color: #A0522D; color: white;">{{ $delivery->status }}</span>
                                        @else
                                            <span class="badge" style="background-color: #D2691E; color: white;">{{ $delivery->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $delivery->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('transporter.deliveries') }}" class="btn btn-sm" style="background-color: #8B4513; color: white;">
                                            <i class='bx bx-edit'></i> Manage
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class='bx bx-truck' style="font-size: 3rem; color: #CD853F;"></i>
                                            <p class="mt-2" style="color: #8B4513;">No current deliveries found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.stats-icon {
    position: absolute;
    top: 10px;
    right: 15px;
}

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
    color: #8B4513;
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.8em;
    border-radius: 15px;
}

h2 {
    font-weight: 700;
}

.btn {
    border-radius: 20px;
    transition: all 0.2s;
}

.btn:hover {
    transform: scale(1.05);
}
</style>
@endsection
