@extends('layouts.app')
@section('page-title', 'Dashboard')
@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection
@section('content')
<!--top cards-->
<div class="container">
<div class="row">
      <div class="col-md-3" >
         <div class="card kpi-card">
            <div class="card-header ">
            <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-title text-muted">Active Orders</h6>
               <span class="stat-icon bg-info-soft delivery"><i class="fa-solid fa-bag-shopping"></i></span>
            </div>
               
            </div>
               <div class="card-body">
               <h3 class="ml-2 kpi-figure"> {{$orders}} </h3> 
               {{-- <div id="chart-j" class="kpi-chart-container"></div> --}}
               </div>  
               
         </div>
      </div>
        <div class="col-md-3" >
         <div class="card kpi-card">
            <div class="card-header ">
            <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-title text-muted">Delivered Batches</h6>
               <span class="stat-icon bg-success-soft money"><i class="fa-solid fa-circle-check"></i></span>
            </div>
            </div>
               <div class="card-body ">
               {{-- <div class="kpi-chart-container"></div>  --}}
               <h3 class="ml-2">{{$delivered}}</h3>
               </div>
            </div>
        </div>
         <div class="col-md-3" >
         <div class="card kpi-card">
            <div class="card-header ">
            <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-title text-muted">Unpaid Invoices</h6>
               <span class="stat-icon bg-danger-soft cancelled"><i class="fa-solid fa-file-invoice-dollar"></i></span>
            </div>   
            </div>
               <div class="card-body ">
               {{-- <div class="kpi-chart-container"></div> --}}
               {{-- <h3 class="ml-2"> {{$invoices}} </h3>     --}}
               </div>
         </div>
      </div>
       <div class="col-md-3" >
         <div class="card kpi-card">
            <div class="card-header ">
             <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-title text-muted">Pending Deliveries</h6>
               <span class="stat-icon bg-warning-soft pending"><i class="fa-solid fa-clock"></i></span>
            </div> 
            </div>
               <div class="card-body ">
                    {{-- <div class="kpi-chart-container"></div>  --}}
                    <h3 class="ml-2"> {{$pending}} </h3>    
               </div>
         </div>
      </div>
</div>

                    <div class="row mb-4">
                        <div class="col-md-7">
                            <div class="modern-card">
                                <div class="card-header ">
                                    <h4 class="card-title">Order Volume</h4>
                                </div>
                                <div class="card-body ">
                                    <div id="chart-v"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">    
                           <livewire:recent-activity/>           
               </div>
            </div>

    <!-- Recent Orders Table -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-list-ul"></i> Recent Orders
            </h5>
        </div>
            <livewire:vendor-recent-orders-table/>
    </div>
</div>
@endsection
