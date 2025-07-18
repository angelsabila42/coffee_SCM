@extends('layouts.app')
@section('page-title', 'Analytics')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection
@section('report-btn')
@livewire('analytics')
@endsection

@section('content')
   <div class="row">
   @if(isset($deliveryStatusData))
      <div class="col-md-5" >
         <div class="card">
            <div class="card-header ">
               {{-- <h4 class="card-title">Deliveries</h4> --}}
            </div>
               <div class="card-body ">
                  <!--Apex Pie Chart-->
                  <div id="chart-c"></div>
               </div>
         </div>
      </div>
      @endif
         <div class="col-md-7">
            <div class="card">
               <div class="card-header ">
                  {{-- <h4 class="card-title">Top Sellers</h4> --}}
               </div>
                  <div class="card-body ">
                  <!--Apex Bar Chart-->
                     <div id="chart-b" ></div>
                  </div>
            </div>
         </div>
   </div>
         <div class="row">
            <div class="col-md-7">
               <div class="card ">
                  <div class="card-header ">
                     {{-- <h4 class="card-title">Sales Performance</h4> --}}
                  </div>
                     <div class="card-body ">
                        <div id="chart-e"></div>
                     </div>
               </div>
            </div>
               <div class="col-md-5">
                  <div class="card ">
                     <div class="card-header ">
                     {{-- <h4 class="card-title">Coffee Sold</h4> --}}
                     </div>
                        <!--Apex donut chart-->
                        <div class="card-body ">
                           <div id="chart-r" ></div>
                        </div>
                  </div>
               </div>
         </div>
                     <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-header ">
                        {{-- <h4 class="card-title">Predicted Demand</h4> --}}
                     </div>
                        <div class="card-body ">
                           <!--Apex Line graph-->
                              <div id="chart-x"></div>
                        </div>
                  </div>
               </div>
            </div> 
         <div class="row">
            <div class="col-md-5">
               <div class="card ">
                  <div class="card-header ">
                     {{-- <h4 class="card-title">Coffee Purchased</h4> --}}
                  </div>
                     <div class="card-body ">
                        <div id="chart-k"></div>
                     </div>
               </div>
            </div>
               <div class="col-md-7">
                  <div class="card ">
                     <div class="card-header ">
                     {{-- <h4 class="card-title">Sales Performance</h4> --}}
                     </div>
                        <!--Apex donut chart-->
                        <div class="card-body ">
                           <div id="chart-g" ></div>
                        </div>
                  </div>
               </div>
         </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-header ">
                        {{-- <h4 class="card-title">Predicted Sales</h4> --}}
                     </div>
                        <div class="card-body ">
                           <!--Apex Line graph-->
                              <div id="chart-l"></div>
                        </div>
                  </div>
               </div>
            </div>         
@endsection

