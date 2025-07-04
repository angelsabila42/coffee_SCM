@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<!--top cards-->
{{-- <div class="row">
      <div class="col-md-3" >
         <div class="card kpi-card">
            <div class="card-header ">
            <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title text-muted">Total Orders</h4>
               <span class="kpi-icon order"><i class="fa-solid fa-bag-shopping"></i></span>
            </div>
               
            </div>
               <div class="card-body">
               <h3 class="ml-2 kpi-figure"> {{$order}} </h3> 
               {{-- <div id="chart-j" class="kpi-chart-container"></div> --}}
               {{-- </div>  
         </div>
      </div>
        <div class="col-md-3" >
         <div class="card kpi-card">
            <div class="card-header ">
            <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title text-muted">Total Income</h4>
               <span class="kpi-icon money"><i class="fa-solid fa-money-bill"></i></span>
            </div>
            </div>
               <div class="card-body "> --}}
               {{-- <div class="kpi-chart-container"></div> --}} 
               {{-- <h3 class="ml-2">$1,453,221,324</h3>
               </div>
            </div>
        </div>
         <div class="col-md-3" >
         <div class="card kpi-card">
            <div class="card-header ">
            <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title text-muted">Partners</h4>
               <span class="kpi-icon partner"><i class="fa-solid fa-handshake"></i></span>
            </div>   
            </div>
               <div class="card-body "> --}}
               {{-- <div class="kpi-chart-container"></div> --}}
               {{-- <h3 class="ml-2"> {{$partners}} </h3>    
               </div>
         </div>
      </div>
       <div class="col-md-3" >
         <div class="card kpi-card">
            <div class="card-header ">
             <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title text-muted">Active Deliveries</h4>
               <span class="kpi-icon delivery"><i class="fa-solid fa-truck-fast"></i></span>
            </div> 
            </div>
               <div class="card-body "> --}} 
                    {{-- <div class="kpi-chart-container"></div>  --}}
                    {{-- <h3 class="ml-2">8</h3>    
               </div>
         </div>
      </div>
</div> --}}

<div class="row g-4">
        <!-- Total Orders Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-primary-soft text-primary">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <span class="badge bg-success trend-badge">
                                <i class="fas fa-arrow-up me-1"></i>12.5%
                            </span>
                    </div>
                    <h6 class="text-muted mb-2">Total Orders</h6>
                    <h4 class="mb-3">{{$order}}</h4>
                </div>
            </div>
        </div>

        <!-- Total Income Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-success-soft text-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="badge bg-danger trend-badge">
                                <i class="fas fa-arrow-down me-1"></i>5.2%
                            </span>
                    </div>
                    <h6 class="text-muted mb-2">Total Income</h6>
                    <h4 class="mb-3">$1,453,221,324</h4>
                </div>
            </div>
        </div>

        <!-- Partners Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-warning-soft bg-opacity-10 text-warning">
                            <i class="fas fa-box"></i>
                        </div>
                        <span class="badge bg-success trend-badge">
                                <i class="fas fa-arrow-up me-1"></i>8.4%
                            </span>
                    </div>
                    <h6 class="text-muted mb-2">Partners</h6>
                    <h4 class="mb-3">{{$partners}}</h4>
                </div>
            </div>
        </div>

        <!-- Active Deliveries Card -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-info-soft text-info">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <span class="badge bg-success trend-badge">
                                <i class="fas fa-arrow-up me-1"></i>15.7%
                            </span>
                    </div>
                    <h6 class="text-muted mb-2">Active Deliveries</h6>
                    <h4 class="mb-3">8</h4>
                </div>
            </div>
        </div>
    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header ">
                                    <h4 class="card-title">Sales Performance</h4>
                                </div>
                                <div class="card-body ">
                                    <div id="chart-e"></div>
                                </div>
                            </div>
                        </div>
                <div class="col-md-5">
                   <div class="card ">
                     <div class="card-header ">
                     <h4 class="card-title">Sales Per type</h4>
                     </div>
                        <!--Apex donut chart-->
                        <div class="card-body ">
                            <div id="chart-d" ></div>
                        </div>
                  </div>
               </div>
            </div>
            <livewire:admin-recent-orders-table/>
@endsection
