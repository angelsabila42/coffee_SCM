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
                        <a href="#" class=" nav-link" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                           <i class="fas fa-bell"></i>
                           @if($notifications->count()>0)
                           <span class="notification">{{$notifications->count()}}</span>
                           @endif
                        </a> 
                        {{-- <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#notificationsModal" style="border:none">
                             <i class="fas fa-bell"></i>
                        </button> --}}
                    </li>
                <li class="nav-item">
                {{-- @auth --}}
                    <span>{{Auth::user()->name}}</span>
                    <a href="#" class=" nav-link" data-bs-toggle="modal" data-bs-target="#userProfileModal">
                        <img src="{{Auth::user()->profile_picture}}" alt="" class="rounded_circle" width="30" height="30">
                         {{-- <i class="fas fa-user-circle"> </i> --}}
                    </a>
                    {{-- @else
                    <a href="{{route('login')}}" class = "nav-link">Login</a>
                    @endauth --}}
                </li>
            </ul>
        </div>
    </div>
    <!--NotificationsModal--> 
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Notifications</h5>
               <button type="button" id="settingsButton" class="btn "  data-bs-toggle="modal" data-bs-target="#settingsModal" data-bs-dismiss="modal" style="border:none">
                  <i class="fas fa-cog"></i>
                </button> 
            </div>
            <div class="modal-body">
                <ul class="list-group">
                  @forelse($notifications as $note)
                    <li class="list-group-item">
                      @if($note->type === 'delivery')
                        <i class="fas fa-truck"></i>
                      @elseif($note->type === 'invoice')
                        <i class="fas fa-receipt"></i>
                      @elseif($note->type === 'payment')
                        <i class="fas fa-money-bill-wave"></i>
                      @elseif($note->type === 'message')
                        <i class="fas fa-envelope"></i>
                      @else
                        <i class="fas fa-bell"></i>
                      @endif
                        {{ $note->message }} <br>
                         <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                    </li>
                    @empty
                      <li class="list-group-item text-muted">No new notifications.</li>
                  @endforelse
                </ul>
            </div>
        </div>
     </div>
</div>
{{-- Notification settings modal  --}}
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="">
      @csrf 
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Notification Settings</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label for="alerts" class="form-label">Enable in-app alerts</label>
            <input type="checkbox" name="alerts" class="" >
          </div>
          <div class="col-md-6">
            <label for="alerts" class="form-label">Enable Email Alerts</label>
            <input type="checkbox" name="alerts" class="" >
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Profile Modal -->
<div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body">
         <img src="{{Auth::user()->profile_picture}}" alt="" class="rounded_circle" width="30" height="30">
        <h5 class="mb-3">{{Auth::user()->name}}</h5>
        <!-- Edit Profile -->
        <a href="{{url('/editprofile')}}" class="btn btn-outline-primary w-75 mb-2">
          <i class="fas fa-user-edit me-1"></i> Edit Profile
        </a>
        <!-- Logout -->
        <form action="/logout" method="POST">
          @csrf
          <button type="submit" class="btn btn-outline-danger w-75">
            <i class="fas fa-sign-out-alt me-1"></i> Log out
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
</nav>

