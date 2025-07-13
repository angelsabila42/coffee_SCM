@extends('layouts.app')

@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">Vendor Reports</h2>
        <div>
            <button class="btn" onclick="window.location.reload()" style="background-color: #8B4513; color: white; border-radius: 20px;">
                <i class="bx bx-refresh"></i> Refresh
            </button>
            <button class="btn" onclick="generateReport()" style="background-color: #CD853F; color: white; border-radius: 20px;">
                <i class="bx bx-download"></i> Export Report
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #CD853F, #D2691E); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $totalOrders ?? 0 }}</h4>
                            <p class="mb-0">Total Orders</p>
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
                            <h4 class="mb-0">Ugx {{ number_format($totalRevenue ?? 0, 2) }}</h4>
                            <p class="mb-0">Total Revenue</p>
                        </div>
                        <i class="bx bx-dollar-circle" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #A0522D, #CD853F); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $totalCoffeeKg ?? 0 }} kg</h4>
                            <p class="mb-0">Coffee Sold</p>
                        </div>
                        <i class="bx bx-coffee-bean" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #6B4423, #8B4513); border-radius: 10px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $activeClients ?? 0 }}</h4>
                            <p class="mb-0">Active Clients</p>
                        </div>
                        <i class="bx bx-group" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Filters -->
    <div class="card mb-4" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-filter"></i> Report Filters
            </h5>
        </div>
        <div class="card-body">
            <form id="reportFilters" class="row">
                <div class="col-md-3">
                    <label style="color: #8B4513; font-weight: 600;">Date From</label>
                    <input type="date" name="date_from" class="form-control" 
                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                </div>
                <div class="col-md-3">
                    <label style="color: #8B4513; font-weight: 600;">Date To</label>
                    <input type="date" name="date_to" class="form-control" 
                           style="border: 2px solid #F5F5DC; border-radius: 8px;">
                </div>
                <div class="col-md-3">
                    <label style="color: #8B4513; font-weight: 600;">Coffee Type</label>
                    <select name="coffee_type" class="form-control" 
                            style="border: 2px solid #F5F5DC; border-radius: 8px;">
                        <option value="">All Coffee Types</option>
                        <option value="Arabica">Arabica</option>
                        <option value="Robusta">Robusta</option>
                        <option value="Liberica">Liberica</option>
                        <option value="Excelsa">Excelsa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label style="color: #8B4513; font-weight: 600;">Report Type</label>
                    <select name="report_type" class="form-control" 
                            style="border: 2px solid #F5F5DC; border-radius: 8px;">
                        <option value="sales">Sales Report</option>
                        <option value="inventory">Inventory Report</option>
                        <option value="financial">Financial Report</option>
                        <option value="customer">Customer Report</option>
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <button type="button" onclick="filterReports()" class="btn" 
                            style="background-color: #8B4513; color: white; border-radius: 20px;">
                        <i class="bx bx-search"></i> Generate Report
                    </button>
                    <button type="button" onclick="resetFilters()" class="btn" 
                            style="background-color: #A0522D; color: white; border-radius: 20px;">
                        <i class="bx bx-reset"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Content -->
    <div class="row">
        <!-- Sales Performance Chart -->
        <div class="col-md-8 mb-4">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-line-chart"></i> Sales Performance
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Coffee Types -->
        <div class="col-md-4 mb-4">
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0">
                        <i class="bx bx-coffee-bean"></i> Top Coffee Types
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="coffeeTypesChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Report -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-receipt"></i> Recent Orders Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead style="background-color: #F5F5DC;">
                        <tr>
                            <th style="color: #8B4513;">Order ID</th>
                            <th style="color: #8B4513;">Date</th>
                            <th style="color: #8B4513;">Client</th>
                            <th style="color: #8B4513;">Coffee Type</th>
                            <th style="color: #8B4513;">Quantity</th>
                            <th style="color: #8B4513;">Amount</th>
                            <th style="color: #8B4513;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
                            <td>{{ $order->client_name ?? 'N/A' }}</td>
                            <td>{{ $order->coffee_type ?? 'N/A' }}</td>
                            <td>{{ $order->quantity ?? 0 }} kg</td>
                            <td>Ugx {{ number_format($order->total_amount ?? 0, 2) }}</td>
                            <td>
                                @if($order->status == 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge badge-info">Processing</span>
                                @else
                                    <span class="badge badge-secondary">{{ $order->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No orders available for report</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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

h2 {
    font-weight: 700;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sample data for charts
const salesData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
        label: 'Sales (Ugx)',
        data: [65000, 59000, 80000, 81000, 56000, 75000],
        borderColor: '#8B4513',
        backgroundColor: 'rgba(139, 69, 19, 0.1)',
        tension: 0.1
    }]
};

const coffeeTypesData = {
    labels: ['Arabica', 'Robusta', 'Liberica', 'Excelsa'],
    datasets: [{
        data: [45, 30, 15, 10],
        backgroundColor: ['#8B4513', '#A0522D', '#CD853F', '#D2691E']
    }]
};

// Initialize charts
const salesChart = new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: salesData,
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const coffeeTypesChart = new Chart(document.getElementById('coffeeTypesChart'), {
    type: 'doughnut',
    data: coffeeTypesData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function filterReports() {
    // Implement report filtering logic
    console.log('Filtering reports...');
    // You can add AJAX call here to filter reports based on form data
}

function resetFilters() {
    document.getElementById('reportFilters').reset();
}

function generateReport() {
    // Implement report export logic
    console.log('Generating report...');
    // You can add AJAX call here to generate and download report
}
</script>
@endsection
@endsection
