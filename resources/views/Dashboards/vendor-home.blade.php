@extends('layouts.app')
@section('page-title', 'Dashboard')
@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">Vendor Dashboard</h2>
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
                            <h4 class="mb-0">{{ $orders ?? 0 }}</h4>
                            <p class="mb-0">Active Orders</p>
                        </div>
                        <i class="bx bx-package" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #8B4513, #A0522D); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $delivered ?? 0 }}</h4>
                            <p class="mb-0">Delivered Batches</p>
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
                            <h4 class="mb-0">{{ $invoices ?? 0 }}</h4>
                            <p class="mb-0">Unpaid Invoices</p>
                        </div>
                        <i class="bx bx-file-text" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #6B4423, #8B4513); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $pending ?? 0 }}</h4>
                            <p class="mb-0">Pending Deliveries</p>
                        </div>
                        <i class="bx bx-clock-alt" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Order Volume Chart -->
        <div class="col-md-8 mb-4">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-line-chart"></i> Order Volume
                    </h5>
                </div>
                <div class="card-body">
                    <div id="chart-v" style="min-height: 300px;">
                        <!-- Chart will be rendered here -->
                        <canvas id="orderVolumeChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-md-4 mb-4">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-activity"></i> Recent Activity
                    </h5>
                </div>
                <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                    <livewire:recent-activity/>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-list-ul"></i> Recent Orders
            </h5>
        </div>
        <div class="card-body">
            <livewire:admin-recent-orders-table/>
        </div>
    </div>
</div>

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

.btn {
    border-radius: 20px;
    transition: all 0.2s;
}

.btn:hover {
    transform: scale(1.05);
}

h2 {
    font-weight: 700;
}

/* Chart container styling */
#chart-v {
    border-radius: 8px;
}

/* Activity feed styling */
.card-body::-webkit-scrollbar {
    width: 6px;
}

.card-body::-webkit-scrollbar-track {
    background: #F5F5DC;
    border-radius: 3px;
}

.card-body::-webkit-scrollbar-thumb {
    background: #CD853F;
    border-radius: 3px;
}

.card-body::-webkit-scrollbar-thumb:hover {
    background: #8B4513;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sample data for order volume chart
const orderVolumeData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
        label: 'Orders',
        data: [12, 19, 8, 15, 25, 18],
        borderColor: '#8B4513',
        backgroundColor: 'rgba(139, 69, 19, 0.1)',
        tension: 0.4,
        fill: true
    }]
};

// Initialize order volume chart
const orderChart = new Chart(document.getElementById('orderVolumeChart'), {
    type: 'line',
    data: orderVolumeData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#F5F5DC'
                }
            },
            x: {
                grid: {
                    color: '#F5F5DC'
                }
            }
        }
    }
});
</script>
@endsection
@endsection
