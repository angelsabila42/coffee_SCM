@section('sidebar-item')
<ul class="sidebar-nav">
        <li class="sidebar-item">
             <a href="{{route('importer.dashboard')}}" class="sidebar-link">
             <i class='bxr  bx-grid-column-right'  ></i> 
             <span>Dashboard</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('importer.orders')}}" class="sidebar-link">
             <i class='bx  bx-clipboard-detail'  ></i>
             <span>Orders</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('importer.transactions')}}" class="sidebar-link">
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