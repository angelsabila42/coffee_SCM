<nav class="navbar navbar-expand-lg" color-on-scroll="500">
    @php
        $notifications = auth()->check() ? auth()->user()->unreadNotifications : collect([]);
    @endphp
    <div class="container-fluid">
        <div class="row w-100 align-items-center flex-nowrap">
            <div class="col-auto d-flex align-items-center">
                <a class="navbar-brand me-3" href="{{ url('/') }}">
                    <img src="{{ asset('images/globalbean-logo.png') }}" alt="Global Bean Connect Logo" class="navbar-logo" style="height:48px; width:auto;">
                </a>
            </div>
            <div class="col d-flex justify-content-center">
                @livewire('search-bar')
            </div>
            <div class="col-auto">
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <!-- Notification Bell -->
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                            <i class="fas fa-bell"></i>
                            @if($notifications->count() > 0)
                                <span class="badge bg-danger notification">{{ $notifications->count() }}</span>
                            @endif
                        </a> 
                    </li>
                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown d-flex align-items-center">
                    @if(Auth::check())
                        <span class="me-2">{{ Auth::user()->name }}</span>
                        <a class="nav-link dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                        </a>
                         <div class="dropdown-menu dropdown-menu-right p-3 mt-2 shadow-lg" aria-labelledby="userDropdown" style="min-width: 280px; max-width: 300px;">
                            <div class="text-center">
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}" class="rounded-circle mb-2" width="60" height="60" style="object-fit: cover;">
                                <h6 class="mb-2 text-capitalize" >{{ Auth::user()->name }}</h6>
                                <p class="text-muted small mb-0" style="text-transform: none;">{{ Auth::user()->email }}</p>
                            </div>
                            <a class="dropdown-item" href="{{ url('/editprofile') }}">
                                <i class="fas fa-user-edit mr-2"></i> Edit Profile
                            </a>
                            <form action="/logout" method="POST" class="m-0 p-0">
                              @csrf
                                <button type="submit" class="btn btn-link dropdown-item">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Log out
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="me-2">Guest</span>
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </a>
                    @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Notifications Modal -->
    <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notifications</h5>
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#settingsModal" data-bs-dismiss="modal" style="border: none;">
                        <i class="fas fa-cog"></i>
                    </button> 
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @forelse($notifications as $note)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">
                                        {{ $note->data['title'] ?? 'Notification' }}
                                    </div>
                                    {{ $note->data['message'] ?? 'No message available.' }}
                                </div>
                                <span class="badge bg-secondary rounded-pill">
                                    {{ $note->created_at->diffForHumans() }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">
                                No new notifications.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Settings Modal -->
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
                            <input type="checkbox" name="alerts">
                        </div>
                        <div class="col-md-6">
                            <label for="email_alerts" class="form-label">Enable Email Alerts</label>
                            <input type="checkbox" name="email_alerts">
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
    {{-- <div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body">
                    @if(Auth::check())
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="rounded-circle mb-2" width="60" height="60">
                        <h5 class="mb-3">{{ Auth::user()->name }}</h5>
                        <a href="{{ url('/editprofile') }}" class="btn btn-outline-primary w-75 mb-2">
                            <i class="fas fa-user-edit me-1"></i> Edit Profile
                        </a>
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
    </div> --}}
</nav>

<!-- JavaScript to mark notifications as read -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationModal = document.getElementById('notificationsModal');

        notificationModal.addEventListener('shown.bs.modal', function () {
            fetch('/notifications/mark-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    const badge = document.querySelector('.notification');
                    if (badge) {
                        badge.remove();
                    }
                } else {
                    console.error('Failed to mark notifications as read');
                }
            });
        });
    });
</script>
