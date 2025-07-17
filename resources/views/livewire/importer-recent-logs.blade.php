<div>
<div>
<div class="modern-card ">
                <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0 card-title ml-4">Activity Logs</h4>
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
                                        <p class="text-muted mb-2"> {{ $log->data['order_id'] ??'' }} </p>
                                    </div>
                                </div>
                            </div>
                        
                    @endforeach
                    </div>
                    </div> 
                </div>
                </div>
          


</div>
