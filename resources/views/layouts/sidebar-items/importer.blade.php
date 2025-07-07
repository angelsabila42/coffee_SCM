@section('sidebar-item')
<ul class="sidebar-nav">
        <li class="sidebar-item">
             <a href="#" class="sidebar-link">
             <i class="nc-icon nc-grid-45"></i>
             <span>Dashboard</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="{{route('importer.orders')}}" class="sidebar-link">
             <i class="nc-icon nc-notes"></i>
             <span>Orders</span>
             </a>
        </li> 
        <li class="sidebar-item">
             <a href="#" class="sidebar-link">
             <i class="nc-icon nc-money-coins"></i>
             <span>Transactions</span>
             </a>
        </li>   
             <li class="sidebar-item">
             <a href="{{ route('chat') }}" class="sidebar-link">
             <i class="nc-icon nc-chat-round"></i>
             <span>Chat</span>
             </a>
        </li>
    </ul>
    @endsection