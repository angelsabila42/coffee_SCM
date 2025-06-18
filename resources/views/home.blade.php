@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')
<!--top cards-->
<div class="row ">
      <div class="col-md-3" >
         <div class="card rounded-sm">
            <div class="card-header ">
               <h4 class="card-title">Total Orders</h4>
            </div>
               <div class="card-body ">
                  <!--Apex Pie Chart-->
                  <h6>21,324</h6>
               </div>
         </div>
      </div>
        <div class="col-md-3" >
         <div class="card rounded-sm">
            <div class="card-header ">
               <h4 class="card-title">Total Income</h4>
            </div>
               <div class="card-body ">
                  <h6>$1,453,221,324</h6>
               </div>
            </div>
        </div>
         <div class="col-md-3" >
         <div class="card rounded-sm">
            <div class="card-header ">
               <h4 class="card-title">Partners</h4>
            </div>
               <div class="card-body ">
                  <h6>100</h6>
               </div>
         </div>
      </div>
       <div class="col-md-3" >
         <div class="card rounded-sm">
            <div class="card-header ">
               <h4 class="card-title">Active Deliveries</h4>
            </div>
               <div class="card-body ">
                  <h6>8</h6>
               </div>
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
                                    <div id="chartActivity" class="ct-chart"></div>
                                </div>
                                <div class="card-footer ">
                                    <div class="legend">
                                        <i class="fa fa-circle text-info"></i> Sales
                                    </div>
                                    <hr>
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
                           <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>
                                    <div class="legend">
                                        <i class="fa fa-circle text-success"></i> Arabica
                                        <i class="fa fa-circle text-warning"></i> Robusta
                           </div>
                        </div>
                  </div>
               </div>
            </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card table-plain-bg">
                                <div class="card-header ">
                                    <h4 class="card-title">Recent Orders</h4>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Salary</th>
                                            <th>Country</th>
                                            <th>City</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Dakota Rice</td>
                                                <td>$36,738</td>
                                                <td>Niger</td>
                                                <td>Oud-Turnhout</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Minerva Hooper</td>
                                                <td>$23,789</td>
                                                <td>Curaçao</td>
                                                <td>Sinaai-Waas</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Sage Rodriguez</td>
                                                <td>$56,142</td>
                                                <td>Netherlands</td>
                                                <td>Baileux</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Philip Chaney</td>
                                                <td>$38,735</td>
                                                <td>Korea, South</td>
                                                <td>Overland Park</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Doris Greene</td>
                                                <td>$63,542</td>
                                                <td>Malawi</td>
                                                <td>Feldkirchen in Kärnten</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>Mason Porter</td>
                                                <td>$78,615</td>
                                                <td>Chile</td>
                                                <td>Gloucester</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
@endsection
