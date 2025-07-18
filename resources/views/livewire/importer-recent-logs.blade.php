<div class="modern-card">
    <!-- Header -->
    <div class="card-header bg-light border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-history text-primary me-2"></i>
                Activity Logs
            </h5>
            <div class="d-flex gap-2">
                @if(!$showAll)
                    <button wire:click="toggleShowAll" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-expand-arrows-alt me-1"></i>View All
                    </button>
                @else
                    <button wire:click="toggleShowAll" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-compress-arrows-alt me-1"></i>Show Recent
                    </button>
                @endif
            </div>
        </div>
        
        <!-- Activity Filters -->
        @if($showAll)
        <div class="mt-3">
            <div class="d-flex flex-wrap gap-2">
                <button wire:click="clearFilter" 
                        class="btn btn-sm {{ $filterType === '' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    All Activities
                </button>
                @foreach($activityCounts as $type => $count)
                    <button wire:click="setFilter('{{ $type }}')" 
                            class="btn btn-sm {{ $filterType === $type ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ ucfirst(str_replace('-', ' ', $type)) }} ({{ $count }})
                    </button>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="card-body p-0">
        <!-- Activity Timeline -->
        <div class="activity-timeline" style="max-height: {{ $showAll ? '600px' : '400px' }}; overflow-y: auto;">
            @forelse($logs as $log)
                @php($style = $log->style)
                
                <!-- Activity Item -->
                <div class="activity-item p-3 border-bottom">
                    <div class="d-flex gap-3">
                        <div class="activity-icon {{ $style['icon_bg'] }} {{ $style['icon_text'] }} rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="{{ $style['icon'] }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1 text-dark">{{ $log->title }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $log->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst(str_replace('-', ' ', $log->type)) }}
                                </span>
                            </div>
                            
                            @if($log->data && count($log->data) > 0)
                                <div class="activity-details">
                                    {{-- Login/Logout specific information --}}
                                    @if($log->type === 'login' && isset($log->data['login_time']))
                                        <small class="text-success d-block">
                                            <i class="fas fa-sign-in-alt me-1"></i>
                                            Login Time: {{ \Carbon\Carbon::parse($log->data['login_time'])->format('M d, Y h:i A') }}
                                        </small>
                                    @endif
                                    
                                    @if($log->type === 'logout' && isset($log->data['logout_time']))
                                        <small class="text-warning d-block">
                                            <i class="fas fa-sign-out-alt me-1"></i>
                                            Logout Time: {{ \Carbon\Carbon::parse($log->data['logout_time'])->format('M d, Y h:i A') }}
                                        </small>
                                        @if(isset($log->data['session_duration']))
                                            <small class="text-info d-block">
                                                <i class="fas fa-stopwatch me-1"></i>
                                                Session Duration: {{ $log->data['session_duration'] }}
                                            </small>
                                        @endif
                                    @endif
                                    
                                    {{-- Order specific information --}}
                                    @if(isset($log->data['order_id']))
                                        <small class="text-info">
                                            <i class="fas fa-box me-1"></i>
                                            Order ID: {{ $log->data['order_id'] }}
                                        </small>
                                    @endif
                                    
                                    @if(isset($log->data['reason']))
                                        <small class="text-muted d-block">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Reason: {{ $log->data['reason'] }}
                                        </small>
                                    @endif
                                    
                                    @if(isset($log->data['amount']))
                                        <small class="text-success d-block">
                                            <i class="fas fa-money-bill me-1"></i>
                                            Amount: UGX {{ number_format($log->data['amount'], 2) }}
                                        </small>
                                    @endif
                                </div>
                            @endif
                            
                            @if($log->ip_address)
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    IP: {{ $log->ip_address }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-history fa-3x mb-3" style="opacity: 0.3;"></i>
                        <h6>No Activity Logs Found</h6>
                        <p class="mb-0">Your recent activities will appear here.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($showAll && method_exists($logs, 'links'))
            <div class="card-footer bg-light">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
    
    <!-- Quick Stats -->
    @if($activityCounts->count() > 0)
    <div class="card-footer bg-light">
        <div class="row text-center">
            <div class="col">
                <small class="text-muted d-block">Total Activities</small>
                <strong>{{ $activityCounts->sum() }}</strong>
            </div>
            <div class="col">
                <small class="text-muted d-block">Most Recent</small>
                <strong>{{ $logs->first()?->created_at?->format('M d, Y') ?? 'N/A' }}</strong>
            </div>
            <div class="col">
                <small class="text-muted d-block">Types</small>
                <strong>{{ $activityCounts->count() }}</strong>
            </div>
        </div>
    </div>
    @endif
</div>
