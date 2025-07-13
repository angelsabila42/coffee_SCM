@section('sidebar-items')
<ul class="sidebar-nav">
        <li class="sidebar-item">
             <a href="{{route('transporter.dashboard')}}" class="sidebar-link">
             <i class='bx bx-grid-alt'></i> 
             <span>Dashboard</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('transporter.deliveries')}}" class="sidebar-link">
             <i class='bx bx-truck'></i>
             <span>Deliveries</span>
             </a>
        </li>
        <li class="sidebar-item">
             <a href="{{route('transporter.drivers')}}" class="sidebar-link">
             <i class='bx bx-user'></i>
             <span>Drivers</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('transporter.transactions')}}" class="sidebar-link">
             <i class='bx bx-dollar-circle'></i>
             <span>Transactions</span>
             </a>
        </li>   
        <li class="sidebar-item">
             <a href="{{ route('transporter.profile') }}" class="sidebar-link">
             <i class='bx bx-user-circle'></i> 
             <span>Profile</span>
             </a>
        </li>
    </ul>
    @endsection