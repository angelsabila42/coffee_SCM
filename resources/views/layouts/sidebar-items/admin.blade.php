@section('sidebar-items')
<ul class="sidebar-nav">
        <li class="sidebar-item">
             <a href="{{route('home')}}" class="sidebar-link {{request()->routeIs('home') ? 'active' : ''}}">
             <i class='bxr  bx-grid-column-right'  ></i> 
             <span>Dashboard</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('order.index')}}" class="sidebar-link {{request()->routeIs('order.*') ? 'active' : ''}}">
             <i class='bx  bx-clipboard-detail'  ></i> 
             <span>Orders</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('payments.index')}}" class="sidebar-link {{request()->routeIs('payments.index') ? 'active' : ''}}">
             <i class='bx  bx-dollar-circle'  ></i> 
             <span>Transactions</span>
             </a>
        </li>   
        <li class="sidebar-item">
             <a href="{{route('deliveries.index')}}" class="sidebar-link {{request()->routeIs('deliveries.index') ? 'active' : ''}}">
             <i class='bxr  bx-truck'  ></i>  
             <span>Deliveries</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('analytics')}}" class="sidebar-link {{request()->routeIs('analytics') ? 'active' : ''}}">
             <i class='bx  bx-bar-chart-big'  ></i>    
             <span>Analytics</span>
             </a>
        </li>
        <li class="sidebar-item">
             <a href="{{route('chat')}}"  class="sidebar-link {{request()->routeIs('chat') ? 'active' : ''}}">
             <i class='bx  bx-message-bubble'  ></i> 
             <span>Chat</span>
             </a>
        </li>
        <li class="sidebar-item">
             <a href="{{route('reports')}}" class="sidebar-link {{request()->routeIs('reports') ? 'active' : ''}}">
             <i class='bx  bx-file-report'></i>
             <span>Report</span>
             </a>
        </li>
        <li class="sidebar-item">
             <a href="{{url('/inventory')}}" class="sidebar-link {{request()->routeIs('/inventory') ? 'active' : ''}}">
             <i class='bx bx-package' ></i>
             <span>Inventory</span>
             </a>
        </li>
        <li class="sidebar-item">
             <a href="{{ route('staff_management.staff') }}" class="sidebar-link {{request()->routeIs('staff_management.staff') ? 'active' : ''}}">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 
                 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 
                 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
             </svg>
             <span>Staff Management</span>
            
             </a>
        </li>
        {{-- <li class="sidebar-item">
             <a href="#" class="sidebar-link">
             <i class='bx  bx-cog'  ></i> 
             <span>Settings</span>
             </a>
        </li> --}}
    </ul>
    @endsection