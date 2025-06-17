<div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                   <!-- <a href="http://www.creative-tim.com" class="simple-text">
                        Creative Tim
                    </a>-->
                </div>
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="dashboard.html">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{url('/orders')}}">
                           <i class="fas fa-box"></i>
                            <p>orders</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./table.html">
                           <i class="fas fa-exchange-alt"></i>
                            <p>Transactions</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./typography.html">
                            <i class="fas fa-truck"></i>
                            <p>Deliveries</p>
                        </a>
                    </li>
                    
                    <li>
                        <a class="nav-link" href="./maps.html">
                           <i class="fas fa-chart-bar"></i>
                            <p>Analytics</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./notifications.html">
                            <i class="fas fa-comments"></i>
                            <p>Chat</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./notifications.html">
                            <i class="fas fa-file-alt"></i>
                            <p>Reports</p>
                        </a>
                    </li><li>
                        <a class="nav-link" href="{{url('/inventory')}}">
                            <i class="fas fa-warehouse"></i>
                            <p>Inventory</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./notifications.html">
                            <i class="fas fa-users"></i>
                            <p>Staff Management</p>
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#pablo"></a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="nav navbar-nav mr-auto">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-palette"></i>
                                    <span class="d-lg-none">Dashboard</span>
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <i class="nc-icon nc-planet"></i>
                                    <span class="notification">5</span>
                                    <span class="d-lg-none">Notification</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Notification 1</a>
                                    <a class="dropdown-item" href="#">Notification 2</a>
                                    <a class="dropdown-item" href="#">Notification 3</a>
                                    <a class="dropdown-item" href="#">Notification 4</a>
                                    <a class="dropdown-item" href="#">Another notification</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nc-icon nc-zoom-split"></i>
                                    <span class="d-lg-block">&nbsp;Search</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">Account</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="no-icon">Dropdown</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon">Log out</span>
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
    <div class="col-md-3"><div class="card"><div class="card-body"><strong>1</strong><br>Blelow Minimum</div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><strong>115000kg</strong><br>Total Stock</div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><strong>4</strong><br>Warehouses</div></div></div>
    
  </div>

            

      <div class="pagination">
        <button>1</button>
        <button class="active">2</button>
        <button>3</button>
        <button>4</button>
        <button>5</button>
        <button>6</button>
        <button>7</button>
        <button>...</button>
        <button>20</button>
      </div>
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
