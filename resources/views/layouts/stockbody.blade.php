<div class="wrapper">
       <div>
<aside id="sidebar">
    <div class="d-flex justify-content-between p-4">
        <div class="sidebar-logo mr-1">
            <a href="#">GlobalBean Connect</a>
        </div>
    
    <button type="button" class="toggle-btn border-0">
        <i id="icon" class='bx bxs-chevrons-right'></i>
    </button>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
             <a href="/home/dashboard" class="sidebar-link">
             <i class="nc-icon nc-grid-45"></i>
             <span>Dashboard</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{url('/orders')}}" class="sidebar-link">
             <i class="nc-icon nc-notes"></i>
             <span>Orders</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('payments.index')}}" class="sidebar-link">
             <i class="nc-icon nc-money-coins"></i>
             <span>Transactions</span>
             </a>
        </li>   
        <li class="sidebar-item">
             <a href="{{route('deliveries.index')}}" class="sidebar-link">
             <i class="nc-icon nc-delivery-fast"></i>
             <span>Deliveries</span>
             </a>
        </li> 
             <li class="sidebar-item">
             <a href="{{route('analytics')}}" class="sidebar-link">
             <i class="nc-icon nc-chart-bar-32"></i>
             <span>Analytics</span>
             </a>
        </li>
             <li class="sidebar-item">
             <a href="#" class="sidebar-link">
             <i class="nc-icon nc-chat-round"></i>
             <span>Chat</span>
             </a>
        </li>
             <li class="sidebar-item">
             <a href="{{route('reports')}}" class="sidebar-link">
             <i class='bx bxs-report'></i>
             <span>Report</span>
             </a>
        </li>
             <li class="sidebar-item">
             <a href="{{url('/inventory')}}" class="sidebar-link">
             <i class='bx bx-package' ></i>
             <span>Inventory</span>
             </a>
        </li>
             <li class="sidebar-item">
             <a href="#" class="sidebar-link">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 
                 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 
                 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
             </svg>

             <span>Staff Management</span>
             </a>
        </li>
    </ul>
</aside>
</div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                            <li class="nav-item">
                                <!--the company log will go here or at top of the side bar-->
                            </li>
                            <li class="dropdown nav-item">
                                <input type="text" placeholder="Search" style="border-radius: 30px">
                            </li> 
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="fas fa-bell"></i>
                                    <span class="notification">5</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <span>Arnest</span>
                                <a class="nav-link" href="#pablo">
                                    <img src="" alt="profile pic">
                                    {{-- <span class="no-icon">Log out</span> --}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
                   <!--this is the content for the body-->
            <div class="container bg-white p-4 rounded shadow-sm">
    <div class="section-header">Stock Details</div>

    <div class="row">
      <div class="col-md-6">
        <p><span class="detail-label">Inventory ID:</span> {{$inventory->inventory_id}}</p>
        <p><span class="detail-label">Coffee Type:</span> {{$inventory->coffee_type}}</p>
        <p><span class="detail-label">Grade:</span>{{$inventory->grade}}</p>
        <p><span class="detail-label">Warehouse Name:</span> {{$inventory->warehouse_name}}</p>
      </div>
      <div class="col-md-6">
        <p>
          <span class="detail-label">Quantity in Stock:</span> {{$inventory->quantity}}
          <button class="btn btn-sm btn-dark edit-btn">Edit</button>
        </p>
        <p>
          <span class="detail-label">Min Threshold:</span> {{$inventory->threshold}}
          <button class="btn btn-sm btn-dark edit-btn">Edit</button>
        </p>
        <p><span class="detail-label">Last Updated:</span> {{$inventory->last_updated}}</p>
        <p><span class="detail-label">Status:</span> @if($inventory->quantity < $inventory->threshold)
                           <span class="text-danger">Low X</span>
                             @else 
                           <span class="text-success">In Stock ✔️</span>
                           @endif
        </p>
      </div>
    </div>

    <hr>

    <h5 class="mt-4">Inventory Log</h5>
    <table class="table table-bordered table-hover">
      <thead class="table-light">
        <tr>
          <th>Date</th>
          <th>Action</th>
          <th>Quantity</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>19 May, 2021 - 10:10 AM</td>
          <td>Stock Added</td>
          <td>+500</td>
        </tr>
        <tr>
          <td>18 May, 2021 - 3:12 PM</td>
          <td>Stock Removed</td>
          <td>-100</td>
        </tr>
      </tbody>
    </table> 
  
    <!--end of this body-->
        </div>
    </div>