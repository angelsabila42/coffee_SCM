@extends('layouts.app')
@section('page-title', 'Dashboard')
@section('sidebar-items')
@include('layouts.sidebar-items.vendor')
@endsection
@section('content')
<!--top cards-->
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
               <h4 class="ml-2 kpi-figure"> {{$orders}} </h4> 
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
               <h4 class="ml-2">{{$delivered}}</h4>
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
               {{-- <h4 class="ml-2"> {{$invoices}} </h4>     --}}
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
                    <h4 class="ml-2"> {{$pending}} </h4>    
               </div>
         </div>
      </div>
</div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="modern-card">
                                <div class="card-header ">
                                    <h4 class="card-title">Sales Performance</h4>
                                </div>
                                <div class="card-body ">
                                    <div id="chart-e"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">    
                            @include('livewire.recent-activity')            
               </div>
            </div>

            <div class="row mt-4">
            <div class="col-md-12">
            <livewire:admin-recent-orders-table/>
            </div>
            </div>

            
            {{-- <x-tabs :tabs="[ 'vendor-order' => 'Incoming Orders',
            'invoices' => 'Invoices',
            'qa' => 'QA Reports',]" /> --}}
            
@endsection
