{{-- summary cards --}}
    <div class="row mb-4">
        <div class="col">
            <div class="card ">
                <div class="card-body">
                   {{-- Dynamically get total staff count --}}
                    <p>Active Deliveries</p>
                    <h3>3</h3> 
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card ">
                <div class="card-body">
                    {{-- Dynamically get absent staff count --}}
                    <p>Pending Deliveries</p>
                    <h3>4</h3>
                </div>
            </div>
        </div>
        <div class="col" >
            <div class="card ">
                <div class="card-body">
                   <p>Completed</p>
                   <h3>4</h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card ">
                <div class="card-body">
                    <p>Delayed</p>
                    <h3>4</h3>
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
                    <tr>
                        <td>NX-009</td>
                        <td>Arabica</td>
                        <td>3000kg</td>
                        <td>Mbale</td>
                        <td>Mombasa</td>
                        <td>Acccepted</td>
                        <td>2025-09-05</td>
                        <td>Deleted</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>