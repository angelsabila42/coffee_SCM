<div>
        <div class="col-md-12">
                <div class="d-flex justify justify-content-between align-items-center">
                    
                    <!--Search bar-->
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="form mr-3">
                         <label class="">Start Date: </label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="form mr-3">
                          <label class="">End Date: </label>
                            <input type="date" class="form-control">
                        </div>
                          <button class="btn btn-primary btn-fill btn-sm mt-4"><!--i class="fa-solid fa-plus pt-1 mr-3"-->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mt-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 
                            1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 
                             2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                        </button>
                    </div>
                    <button class="btn btn-success btn-fill btn-sm"><i class="fa-solid fa-plus pt-1 mr-3"></i>Generate Report</button>
                </div>
                            <div class="card card-plain table-plain-bg">
                                <div class="card-header ">
                                    <!--h4 class="card-title">Table on Plain Background</h4>
                                    <p class="card-category">Here is a subtitle for this table</p-->
                                </div>
                                <div class="card-body table-full-width table-responsive" style="overflow-x:auto;">
                                    <table class="table table-hover" style="font-size: 0.92rem; min-width: 1200px;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="white-space:nowrap;">ID</th>
                                                <th style="white-space:nowrap;">Delivery ID</th>
                                                <th style="white-space:nowrap;">Pickup Location</th>
                                                <th style="white-space:nowrap;">Dispatch Date/Time</th>
                                                <th style="white-space:nowrap;">Destination</th>
                                                <th style="white-space:nowrap;">Quantity</th>
                                                <th style="white-space:nowrap;">Coffee Type</th>
                                                <th style="white-space:nowrap;">Coffee Grade</th>
                                                <th style="white-space:nowrap;">Status</th>
                                                <th style="white-space:nowrap;">Assigned Driver</th>
                                                <th style="white-space:nowrap;">ETA</th>
                                                <th style="white-space:nowrap;">Date Ordered</th>
                                                <th style="white-space:nowrap;">Created At</th>
                                                <th style="white-space:nowrap;">Updated At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($deliveries as $delivery)
                                            <tr wire:key= "{{$delivery->id}}" >
                                                <td style="white-space:nowrap;">{{ $delivery->id }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->delivery_id }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->pickup_location }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->dispatch_date_time }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->delivery_destination }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->quantity }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->coffee_type }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->coffee_grade }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->status }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->assigned_driver }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->eta }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->date_ordered }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->created_at }}</td>
                                                <td style="white-space:nowrap;">{{ $delivery->updated_at }}</td>
                                            </tr>
                                         @endforeach    
                                        </tbody>
                                    </table>
                                </div>
                                <div class="py-4 px-3">
                   
                            </div>
                        </div>
                    </div>
        <div class="d-flex justify-content-center align-items-center col-md-12">
        {{$deliveries->links('pagination::bootstrap-4')}}
        </div>
</div>
        
