
    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <!--<a href="http://www.creative-tim.com" class="simple-text">
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
                        <a class="nav-link" href="">
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
                        <a class="nav-link" href="./notifications.html">
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
            <div class="content">
                <p style="font-size: 1.5em"> Orders</p>
      <div class="top-controls">
        <div class="tabs">
         <a href="{{url('/orders')}}"> <button >Incoming</button></a>
          <button class="active">Outgoing</button>
        </div>
        <div class="right">
          <!--<i class="fas fa-filter">--></i>
          <button style="border-radius: 50px ">+</button><label>New</label>
        </div>
      </div>

      <!--<div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>orderID</th>
                                            <th>Importer<br>Name</th>
                                            <th>Quantity</th>
                                            <th>Coffee<br>Type</th>
                                            <th>Delivery<br>Country</th>
                                            <th>Status</th>
                                            <th>Order<br>date</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>NX-001</td>
                                                <td>Hermanos</td>
                                                <td>Arabica</td>
                                                <td>3000 kg</td>
                                                <td>Germany</td>
                                                <td>Accepted</td>
                                                <td>19 May</td>
                                                <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                <td>NX-002</td>
                                                <td>Bellwether</td>
                                                <td>Robusta</td>
                                                <td>5000 kg</td>
                                                <td>United Kingdom</td>
                                                <td>Sent</td>
                                                <td>18 May</td>
                                                <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                <td>NX-003</td>
                                                <td>Nespresso</td>
                                                <td>Arabica</td>
                                                <td>4000 kg</td>
                                                <td>Germany</td>
                                                <td>Cancelled</td>
                                                <td>17 May</td>
                                                 <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                               <td>NX-004</td>
                                               <td>L'OR</td>
                                               <td>Arabica</td>
                                               <td>1000 kg</td>
                                               <td>Spain</td>
                                               <td>Accepted</td>
                                               <td>23 Apr</td>
                                               <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                <td>NX-005</td>
                                                <td>Mason Porter</td>
                                                <td>Arabica</td>
                                                <td>4000 kg</td>
                                                <td>Germany</td>
                                                <td>Cancelled</td>
                                                <td>17 May</td>
                                                <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                <td>NX-006</td>
                                                <td>Hermanos</td>
                                                <td>Arabica</td>
                                                <td>3000 kg</td>
                                                <td>Germany</td>
                                                <td>Accepted</td>
                                                <td>19 May</td>
                                                <td class="actions"><a>delete</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>-->
                                <div>
   <div class="col-md-12">
   <div class="d-flex justify justify-content-between align-items-center">
                    
                    <!--Search bar-->
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="form">
                                <i class="nc-icon nc-zoom-split"></i>
                            <input type="text" class="form-control form-input" placeholder="Search">
                        </div>
                    </div>
                    <!--<div class="d-flex align-items-center">
                            <label class="text-muted mr-2 mb-0">User Type :</label>
                            <select> 
                                <option value="">All</option>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                    </div>-->
                </div>
                            <div class="card card-plain table-plain-bg">
                                <div class="card-header ">
                                    <!--h4 class="card-title">Table on Plain Background</h4>
                                    <p class="card-category">Here is a subtitle for this table</p-->
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <th class="font-weight-bold">ID</th>
                                            <th class="text-amber">Importer<br>Name</th>
                                            <th>Quantity</th>
                                            <th>Coffee<br>Type</th>
                                            <th>Delivery<br>Country</th>
                                            <th>Status</th>
                                            <th>Order<br>date</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>NX-001</td>
                                                <td>Hermanos</td>
                                                <td>Arabica</td>
                                                <td>3000 kg</td>
                                                <td>Germany</td>
                                                <td>Accepted</td>
                                                <td>19 May</td>
                                                <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                <td>NX-002</td>
                                                <td>Bellwether</td>
                                                <td>Robusta</td>
                                                <td>5000 kg</td>
                                                <td>United Kingdom</td>
                                                <td>Sent</td>
                                                <td>18 May</td>
                                                <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                 <td>NX-003</td>
                                                <td>Nespresso</td>
                                                <td>Arabica</td>
                                                <td>4000 kg</td>
                                                <td>Germany</td>
                                                <td>Cancelled</td>
                                                <td>17 May</td>
                                                 <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                <td>NX-004</td>
                                               <td>L'OR</td>
                                               <td>Arabica</td>
                                               <td>1000 kg</td>
                                               <td>Spain</td>
                                               <td>Accepted</td>
                                               <td>23 Apr</td>
                                               <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                <td>NX-005</td>
                                                <td>Mason Porter</td>
                                                <td>Arabica</td>
                                                <td>4000 kg</td>
                                                <td>Germany</td>
                                                <td>Cancelled</td>
                                                <td>17 May</td>
                                                <td class="actions"><a>delete</a></td>
                                            </tr>
                                            <tr>
                                                <td>NX-006</td>
                                                <td>Hermanos</td>
                                                <td>Arabica</td>
                                                <td>3000 kg</td>
                                                <td>Germany</td>
                                                <td>Accepted</td>
                                                <td>19 May</td>
                                                <td class="actions"><a>delete</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
    <!--   -->
    <!-- <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
        </a>

        <ul class="dropdown-menu">
			<li class="header-title"> Sidebar Style</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Background Image</p>
                    <label class="switch">
                        <input type="checkbox" data-toggle="switch" checked="" data-on-color="primary" data-off-color="primary"><span class="toggle"></span>
                    </label>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <p>Filters</p>
                    <div class="pull-right">
                        <span class="badge filter badge-black" data-color="black"></span>
                        <span class="badge filter badge-azure" data-color="azure"></span>
                        <span class="badge filter badge-green" data-color="green"></span>
                        <span class="badge filter badge-orange" data-color="orange"></span>
                        <span class="badge filter badge-red" data-color="red"></span>
                        <span class="badge filter badge-purple active" data-color="purple"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="header-title">Sidebar Images</li>

            <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="../assets/img/sidebar-1.jpg" alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="../assets/img/sidebar-3.jpg" alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="..//assets/img/sidebar-4.jpg" alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="../assets/img/sidebar-5.jpg" alt="" />
                </a>
            </li>

            <li class="button-container">
                <div class="">
                    <a href="http://www.creative-tim.com/product/light-bootstrap-dashboard" target="_blank" class="btn btn-info btn-block btn-fill">Download, it's free!</a>
                </div>
            </li>

            <li class="header-title pro-title text-center">Want more components?</li>

            <li class="button-container">
                <div class="">
                    <a href="http://www.creative-tim.com/product/light-bootstrap-dashboard-pro" target="_blank" class="btn btn-warning btn-block btn-fill">Get The PRO Version!</a>
                </div>
            </li>

            <li class="header-title" id="sharrreTitle">Thank you for sharing!</li>

            <li class="button-container">
				<button id="twitter" class="btn btn-social btn-outline btn-twitter btn-round sharrre"><i class="fa fa-twitter"></i> · 256</button>
                <button id="facebook" class="btn btn-social btn-outline btn-facebook btn-round sharrre"><i class="fa fa-facebook-square"></i> · 426</button>
            </li>
        </ul>
    </div>
</div>
 -->