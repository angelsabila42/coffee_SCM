{{-- summary cards --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
     <div class="row mb-4">
        <div class="col">
            <div class="card text-white rounded-2 bg-dark">
                <div class="card-body bg-dark rounded-3">
                   {{-- Dynamically get total staff count --}}
                    <p class="card-title text-white">Orders sent</p>
                    <h3>{{ $ordersSent }}</h3> 
                </div>
            </div>
        </div>
        <div class="col ">
            <div class="card ">
                <div class="card-body rounded d-flex ">
                    {{-- Dynamically get absent staff count --}}
                    
                    <div class="mx-3">
                        <span >Pending</span>
                    <h3>{{ $pending }}</h3>
                    </div>
                    <i class="fa-solid fa-spinner"></i>
                </div>
            </div>
        </div>
        <div class="col" >
            <div class="card ">
                <div class="card-body d-flex justify-content-column ">
                    
                   <div class="mx-2">
                      <p class="fw-bold ">In transit</p>
                        <h3>{{ $inTransit }}</h3>
                          
                   </div>
                   <i class="fa-solid fa-truck"></i>
               
                    </div>
            </div>
        </div>
        <div class="col">
            <div class="card ">
                <div class="card-body d-flex">
                    <div class="mx-2">
                    {{-- Dynamically get present staff count --}}
                    <p>Delivered</p>
                    <h3>{{ $delivered }}</h3>
                    </div>
                <i class="fa-solid fa-thumbs-up"></i>
                </div>
            </div>
        </div>
    </div>
{{-- delivery table     --}}
<div>
   <div class="col-md-12">
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
                <table class="table table-hover table-bordered">
                    <thead class="bg-ligh bg-dark ">
                        <tr>
                        <th class="font-weight-bold text-white bg-dark">OrderID</th>
                        <th class="text-amber text-white bg-dark">Coffee Type</th>
                        <th class="text-amber text-white bg-dark">Quantity</th>
                        <th class="text-amber text-white bg-dark">Status</th>
                        <th class="text-amber text-white bg-dark">Order date</th>
                        <th class="text-amber text-white bg-dark">Last update</th>
                        <th class="text-amber text-white bg-dark">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                   

                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->orderID }}</td>
                        <td>{{ $order->coffeeType }}</td>
                        <td>{{ $order->quantity }}kg</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>
                            <form action="{{ route('orders.destroy', $order->id )}} " method="POST" style="display: none;" id="delete-form-{{ $order->id }}">
                            @csrf
                            @method('DELETE')
                            </form>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $order->id }}')">Delete</button>
                          
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

            
        
  