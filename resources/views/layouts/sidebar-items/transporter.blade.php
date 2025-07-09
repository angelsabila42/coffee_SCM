@section('sidebar-item')
<ul class="sidebar-nav">
        <li class="sidebar-item">
             <a href="{{route('vendor.home')}}" class="sidebar-link">
             <i class='bxr  bx-grid-column-right'  ></i> 
             <span>Dashboard</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('deliveries.index')}}" class="sidebar-link">
             <i class='bxr  bx-truck'  ></i>
             <span>Deliveries</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('payments.index')}}" class="sidebar-link">
             <i class='bx  bx-dollar-circle'  ></i>
             <span>Transactions</span>
             </a>
        </li>   
             <li class="sidebar-item">
             <a href="{{ route('chat') }}" class="sidebar-link">
             <i class='bx  bx-message-bubble'  ></i> 
             <span>Chat</span>
             </a>
        </li>
    </ul>
    @endsection