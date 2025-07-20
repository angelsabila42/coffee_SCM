<div class="modern-card ">
                <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0 card-title ml-4 text-brown font-weight-bold">Activity Logs</h4>
                        </div>

                    <div class="card-body p-4">
                        <!-- Activity Timeline -->
                        <div class="activity-timeline scrollbar">
                    @foreach($logs as $log)
                    @php($style = $log->style)
                    
                            <!-- Activity Item -->
                            <div class="activity-item bg-white">
                                <div class="d-flex gap-3">
                                    <div class="activity-icon {{$style['icon_bg']}} {{$style['icon_text']}} ">
                                        <i class="{{$style['icon']}}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            {{-- <h6 class="mb-0">User Login Successful</h6> --}}
                                            <span class="activity-date"> {{$log->created_at->diffForHumans()}} </span>
                                        </div>
                                        <p class="text-muted mb-2"> {{$log->title}} </p>
                                        {{-- <div class="d-flex align-items-center">
                                            <div class="activity-user me-3">
                                                <img src="https://randomuser.me/api/portraits/men/40.jpg" alt="User">
                                            </div>
                                            <span class="text-muted small">IP: 192.168.1.1</span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        
                    @endforeach
                    </div>
                    </div> 
                </div>
                
          

