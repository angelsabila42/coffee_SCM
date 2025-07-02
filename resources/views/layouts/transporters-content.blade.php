{{-- summary cards --}}
    <div class="row mb-4">
        <div class="col">
            <div class="card ">
                <div class="card-body">
                   {{-- Dynamically get active deliveries count --}}
                    <p>Active Deliveries</p>
                    <h3>{{$active}}</h3> 
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card ">
                <div class="card-body">
                    {{-- Dynamically get pending deliveries count --}}
                    <p>Pending Deliveries</p>
                    <h3>{{$pending}}</h3>
                </div>
            </div>
        </div>
        <div class="col" >
            <div class="card ">
                <div class="card-body">
                   <p>Completed</p>
                   <h3>{{$completed}}</h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card ">
                <div class="card-body">
                    <p>Delayed</p>
                    <h3>{{$delayed}}</h3>
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
                <h3>Current Deliveries</h3>
            </div>
        </div>
        <div class="card card-plain table-plain-bg">
            <div class="card-header ">
                <!--h4 class="card-title">Table on Plain Background</h4>
                <p class="card-category">Here is a subtitle for this table</p-->
            </div>
            <div class="card-body table-full-width table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <th class="font-weight-bold">DeliveryID</th>
                        <th class="text-amber">Coffee Type</th>
                        <th>Quantity</th>
                        <th>Pick up Point</th>
                        <th>Destination</th>
                        <th>Status</th>
                        <th>Date ordered</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                    @foreach($deliveries as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->coffee_type}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->pickup_location}}</td>
                        <td>{{$item->delivery_destination}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->date_ordered}}</td>
                        <td>
                            <form action="{{route('transporter.dismiss', $item->id)}}"
                                method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-fill py-1 px-3"><i class="fa-solid fa-trash"></i></button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>