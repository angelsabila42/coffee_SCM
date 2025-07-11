<nav class="navbar navbar-expand-lg " color-on-scroll="500">
{{-- @php
    $notifications = Auth::user()->unreadNotifications;
@endphp --}}
    <div class="container-fluid">
        <div class="collapse navbar-collapse justify-content-end" id="navigation">

                <ul class=" navbar-nav me-auto mb-2 mb-lg-0" >
                
                {{-- search bar --}}
                @livewire('search-bar')
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
                    @if(Auth::check())
                        <span>{{ Auth::user()->name }}</span>
                        <a href="#" class=" nav-link" data-bs-toggle="modal" data-bs-target="#userProfileModal">
                            <img src="{{asset('storage/' .auth()->user()->profile_picture)}}" alt="" class="rounded-circle" width="30" height="30">
                        </a>
                    @else
                        <span>Guest</span>
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-user-circle"></i>
                        </a>
                    @endif

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
                  <li>
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
                      @endif
                        {{ $note->data }} <br>
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
        @if(Auth::check())
          <img src="{{asset('storage/' .auth()->user()->profile_picture)}}" alt="" class="rounded_circle" width="30" height="30">
          <h5 class="mb-3">{{ Auth::user()->name }}</h5>
          <!-- Edit Profile -->
          <a href="{{ url('/editprofile') }}" class="btn btn-outline-primary w-75 mb-2">
            <i class="fas fa-user-edit me-1"></i> Edit Profile
          </a>
          <!-- Logout -->
          <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-75">
              <i class="fas fa-sign-out-alt me-1"></i> Log out
            </button>
          </form>
        @else
          <h5 class="mb-3">Guest</h5>
          <a href="{{ route('login') }}" class="btn btn-outline-primary w-75 mb-2">
            <i class="fas fa-sign-in-alt me-1"></i> Login
          </a>
        @endif
      </div>
    </div>
  </div>
</div>
</nav>



