{{-- summary cards --}}

     <div class="row mb-4"> 
        <div class="col">
            <div class="card  rounded-2  kpi-card">
                <div class="d-flex  card-body justify-content-between ">
                    <div class="  mx-2">
                    
                   {{-- Dynamically get total staff count --}}
                    <p class=" fw-bold">Orders sent</p>
                    <h4>{{ $ordersSent }}</h4> 
                </div>
                <i class="fa-solid fa-bag-shopping stat-icon bg-partner-soft"> </i>
           
                </div>
                 </div>
        </div>
        <div class="col ">
            <div class="card kpi-card"> 
                <div class="card-body rounded d-flex  d-flex justify-content-between">
                   
                    {{-- Dynamically get absent staff count --}}
                    
                    <div class="mx-2">
                        <p class="fw-bold" >Pending</p>
                    <h3>{{ $pending }}</h3>
                    </div>
                    <i class="fa-solid fa-clock stat-icon bg-warning-soft"></i>
                </div>
            </div>
        </div>
        <div class="col" >
            <div class="card kpi-card ">
                <div class="card-body d-flex justify-content-between">
                    {{-- Dynamically get present staff count --}}
                   
                   <div class="mx-2">
                      <p class="fw-bold ">In transit</p>
                        <h3>{{ $inTransit }}</h3>
                          
                   </div>
                   <i class="fa-solid fa-truck stat-icon bg-info-soft text-primary"></i>
               
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card  kpi-card">
                <div class="card-body d-flex justify-content-between  ">
                    <div class="mx-2">
                    {{-- Dynamically get present staff count --}}
                    <p class="fw-bold ">Delivered</p>
                    <h3>{{ $delivered }}</h3>
                    </div>
                   <span class="">
                    <i class="fa-solid fa-circle-check stat-icon bg-success-soft "></i>
                   </span>
                </div>
            </div>
        </div>
    </div>
<div class="modern-card">

                    <div class="row">
                        <div class="col-md-7">
                            <div class="modern-card">
                                <div class="card-header ">
                                    <h4 class="card-title">Order Volume</h4>
                                </div>
                                <div class="card-body ">
                                    <div id="chart-va"></div>
                                </div>
                            </div>
                        </div>

                                <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            var options = {
                                                chart: {
                                                    type: 'line',
                                                    height: 300
                                                },
                                                series: [{
                                                    name: 'Orders',
                                                    data: @json($orderData)
                                                }],
                                                xaxis: {
                                                    categories: @json($months)
                                                }
                                            };

                                            var chart = new ApexCharts(document.querySelector("#chart-va"), options);
                                            chart.render();
                                        });
                            </script>

                        <div class="col-md-5 mb-5" >    
                            <livewire:importer-recent-logs/>           
                        </div>
                    </div>

{{-- delivery table     --}}
<div>
   <div class="col-md-12 mt-5">
        <div class="d-flex justify justify-content-between align-items-center">
            <!--Search bar-->
            <div class="d-flex justify-content-center align-items-center">
                {{-- <div class="form">
                    <i class="nc-icon nc-zoom-split"></i>
                    <input type="text" class="form-control form-input" placeholder="Search">
                </div> --}}
                <h3>Order activity</h3>
            </div>
        </div>
        <div class="card card-plain table-plain-bg">
            <div class="card-header ">
                <!--h4 class="card-title">Table on Plain Background</h4>
                <p class="card-category">Here is a subtitle for this table</p-->
            </div>
            <div class="card-body table-full-width table-responsive">
                <table class="table table-hover ">
                    <thead class="bg-ligh  ">
                        <tr>
                        <th class="font-weight-bold text-dark  fs-5 ">OrderID</th>
                        <th class="text-amber text-dark bg-gray fs-5 ">Coffee Type</th>
                        <th class="text-amber text-dark     fs-5">Quantity</th>
                        <th class="text-amber text-dark    fs-5">Status</th>
                        <th class="text-amber text-dark fs-5     ">Order date</th>
                        <th class=" text-dark   fs-5 ">Last update</th>
                        <th class=" text-dark    fs-5 ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                   

                    @foreach($orders as $order)
                    
                        @php
                            $class = '';
                            if ($order->status == 'Pending'){
                                $class = 'bg-warning';
                            }
                             elseif ($order->status == 'Delivered'){
                                $class = 'bg-info';
                            }
                             elseif ($order->status == 'Requested'){
                                $class = 'bg-primary';
                            }
                             elseif ($order->status == 'Declined'){
                                $class = 'bg-danger';
                            }
                             else $class = 'bg-success';
                        @endphp

                    <tr {{--onclick="window.location.href='{{ route('ImporterOrders.show', $order->id) }}'"--}} style="cursor: pointer;">
                        <td>{{ $order->orderID }}</td>
                        <td>{{ $order->coffeeType }}</td>
                        <td>{{ $order->quantity }}kg</td>
                        <td class="{{ $class }} rounded-pill text-white badge w-100">{{ $order->status }}</td>



                        <td onclick="window.location.href='{{ route('ImporterOrders.show', $order->id) }}'" style="cursor: pointer;">{{ $order->created_at }}</td>
                        <td onclick="window.location.href='{{ route('ImporterOrders.show', $order->id) }}'" style="cursor: pointer;">{{ $order->updated_at }}</td>
                        <td>
                            <form action="{{ route('orders.destroy', $order->id )}} " method="POST" style="display: none;" id="delete-form-{{ $order->id }}">
                            @csrf
                            @method('DELETE')
                            </form>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $order->id }}')"><i class="fa-solid fa-trash"></i></button>
                          
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
   </div>
</div>
{{ $orders->links('pagination::bootstrap-5') }}
</div>


                
  
                                <script>
                                function confirmDelete(orderId) {
                                    Swal.fire({
                                    title: 'Confirm Deletion',
                                    text: "Are you sure you want to delete this order?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, delete it!',
                                    cancelButtonText: 'Cancel'
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                           document.getElementById('delete-form-' + orderId).submit();
                                    }
                                    })
                                }
                                </script>

            
        
  