@extends('layouts.app')
@section('page-title', 'Analytics')
@section('report-btn')
@livewire('analytics')
@endsection

@section('content')
   <div class="row">
      <div class="col-md-5" >
         <div class="card">
            <div class="card-header ">
               <h4 class="card-title">Deliveries</h4>
            </div>
               <div class="card-body ">
                  <!--Apex Pie Chart-->
                  <div id="chart-c"></div>
               </div>
         </div>
      </div>
         <div class="col-md-7">
            <div class="card">
               <div class="card-header ">
                  <h4 class="card-title">Top Sellers</h4>
               </div>
                  <div class="card-body ">
                  <!--Apex Bar Chart-->
                     <div id="chart-b" ></div>
                  </div>
                                <!--div class="card-footer ">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Open
                                        <i class="fa fa-circle text-danger"></i> Click
                                        <i class="fa fa-circle text-warning"></i> Click Second Time
                                    </div>
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> Updated 3 minutes ago
                                    </div>
                                </div-->
            </div>
         </div>
      </div>
         <div class="row">
            <div class="col-md-7">
               <div class="card ">
                  <div class="card-header ">
                     <h4 class="card-title">Sales Performance</h4>
                  </div>
                     <div class="card-body ">
                        <div id="chart-e"></div>
                     </div>
                                <!--div class="card-footer ">
                                    <div class="stats">
                                        <i class="fa fa-check"></i> Data information certified
                                    </div>
                                </div-->
               </div>
            </div>
               <div class="col-md-5">
                  <div class="card ">
                     <div class="card-header ">
                     <h4 class="card-title">Sales Per type</h4>
                     <!--p class="card-category">Backend development</p-->
                     </div>
                        <!--Apex donut chart-->
                        <div class="card-body ">
                           <div id="chart-d" ></div>
                        </div>
                  </div>
               </div>
         </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-header ">
                        <h4 class="card-title">Predicted Sales</h4>
                     </div>
                        <div class="card-body ">
                           <!--Apex Line graph-->
                              <div id="chart-l"></div>
                        </div>
                           <!--div class="card-footer ">
                              <a class="btn btn-primary btn-small update">Update</a>
                           </div-->
                  </div>
               </div>
            </div>         
@endsection
@section('analytics')
@include('layouts.chart_scripts')
@endsection
