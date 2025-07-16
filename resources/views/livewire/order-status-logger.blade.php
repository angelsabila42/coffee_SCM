<div class="col-md-12">
    <div class="modern-card p-4">
        <div class="card-header"><h5>Order Status Logs</h5></div>
            <div class="table-plain-bg">
                <div class="card-header"></div>
                    <div class="card-body table-full-width table-responsive">
                        <div x-data= "confirmDeleteModal">
                            <table class="table table-hover w-100" >
                                <thead class="bg-light">
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                    <th>Timestamp</th>
                                </thead>
                                <tbody>
                                     @foreach($logs as $log)
                                            <tr wire:key= "log-{{$log->id}}">
                                                <td class=""> {{$log->user->name ?? null}} </td>
                                                <td class=""> {{$log->user->role}} </td>
                                                <td class=""> {!!$log->action_status_badge!!} </td>
                                                <td class=""> {{$log->created_at->diffForHumans()}} </td>
                                            </tr>
                                        @endforeach    
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        {{$logs->links()}}
    </div>
</div>
