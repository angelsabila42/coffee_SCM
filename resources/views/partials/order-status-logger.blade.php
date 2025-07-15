<div class="mt-3">
<div class='modern-card'>
    <div class="table-plain-bg">
                                <div class="card-header"></div>
                                <div class="card-body table-full-width table-responsive">
                                <div x-data= "confirmDeleteModal">
                                    <table class="table table-hover" >
                                        <thead class="bg-light">
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Timestamp</th>
                                        </thead>
                                        <tbody>
                                        @foreach($order->statusLog as $log)
                                            <tr  wire:key= "log-{{$log->id}}">
                                                <td class=""> {{$log->user->name}} </td>
                                                <td class=""> {{$log->action}} </td>
                                                <td class=""> {{$log->created_at->diffForHumans()}} </td>
                                            </tr>
                                         @endforeach    
                                        </tbody>
                                    </table>

                                    </div>
                                </div>
                        </div>
</div>
</div>
