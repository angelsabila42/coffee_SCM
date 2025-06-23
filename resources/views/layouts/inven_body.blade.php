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
            <!--cards--> 
            <h3>Inventory Management</h3>
            <div class="row g-4 mb-4">
                 <div class="col-md-3"><div class="card"><div class="crad" ><strong>{{$belowMinimumCount}}</strong><br>Blelow Minimum</div></div></div>
                 <div class="col-md-3"><div class="card"><div class="crad"><strong>{{$totalStock}}kg</strong><br>Total Stock</div></div></div>
                 <div class="col-md-3"><div class="card"><div class="crad"><strong>{{$totalWarehouses}}</strong><br>Warehouses</div></div></div>
            </div>
  <div class="content">
                
      <div class="top-controls">
        <div class="tabs">
         <h3>Inventory</h3>
        </div>
        <div class="right">
          <!--<i class="fas fa-filter">--></i>
          <a href="{{url('/form_modal')}}"><button style="border-radius: 50px ">+</button></a><label>New</label>
        </div>
      </div>

    <div>
   <div class="col-md-12">
   <div class="d-flex justify justify-content-between align-items-center">
                    
                    <!--Search bar-->
                   <!-- <div class="d-flex justify-content-center align-items-center">
                        <div class="form">
                                <i class="nc-icon nc-zoom-split"></i>
                            <input type="text" class="form-control form-input" placeholder="Search">
                        </div>
                    </div>-->
                    <form method="GET" action="{{url('/inventory')}}"class="mb-3">
                        <input type="text" name="search" class="form-control" placeholder="search..."
                        value="{{$search ?? ''}}">
                    </form>
                    <p> searched: <strong>{{ $search ?? 'Nothing '}}</strong></p>
                </div>
                            <div class="card card-plain table-plain-bg">
                                <div class="card-header ">
                                    <!--h4 class="card-title">Table on Plain Background</h4>
                                    <p class="card-category">Here is a subtitle for this table</p-->
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <th class="font-weight-bold" style="text-transform: none">id</th>
                                            <th class="text-amber" style="text-transform: none">coffee_type</th>
                                            <th style="text-transform: none" >grade</th>
                                            <th style="text-transform: none">warehouse_name</th>
                                            <th style="text-transform: none">quantity</th>
                                            <th style="text-transform: none">threshold</th>
                                            <th style="text-transform: none">status</th>
                                            <th style="text-transform: none">last_updated</th>
                                            <th style="text-transform: none">Actions</th>
                                        </thead>
                                        <tbody>
                                            @foreach($inventories as $item)
                                            <tr onclick = "window.location='{{route('stock', $item->id)}}'">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->coffee_type}}</td>
                                                <td>{{$item->grade}}</td>
                                                <td>{{$item->warehouse_name}}</td>
                                                <td>{{$item->quantity}}</td>
                                                <td>{{$item->threshold}}</td>
                                                <td>{{$item->status}}</td>
                                                <td>{{$item->last_updated}}</td>
                                                <td>
                                                    <form action="{{route('inventory.destroy', $item->id)}}"
                                                          method="POST" onsubmit="return confirm('Are you sure you want to 
                                                          deletethis record?');">
                                                       @csrf
                                                       @method('DELETE')
                                                       <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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

            

      {{-- <div class="pagination">
        <button>1</button>
        <button class="active">2</button>
        <button>3</button>
        <button>4</button>
        <button>5</button>
        <button>6</button>
        <button>7</button>
        <button>...</button>
        <button>20</button>
      </div> --}}
    </div>
            <!-- my work-->
            <!--<footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                        </p>
                    </nav>
                </div>
            </footer>-->
        </div>
    </div>
