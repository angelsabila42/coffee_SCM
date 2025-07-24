<div wire:poll.10s>
                        <div class="col-md-12">
                            <div class=" table-plain-bg">
                                <h4 class="card-header">Recent Orders</h4>
                                
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <th>#</th>
                                            <th>OrderID</th>
                                            <th>Coffee Type</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Date Sent</th>
                                            <th  class=" d-flex justify-content-center align-items-center">Actions</th>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr wire:key= "{{$order->id}}" onclick="window.location= '{{route('vendor.order.show', $order->id)}}' " class="cur" >
                                                <td class=""> {{$order->id}} </td>
                                                <td class=""> {{$order->orderID}} </td>
                                                <td class=""> {{$order->coffeeType}} </td>
                                                <td class=""> {{$order->quantity}} </td>
                                                <td x-data= "{selectedStatus: '{{$order->status}}',
                                                    statuses: ['Requested','Pending', 'Declined', 'Delivered', 'Confirmed' ]}"
                                                    x-init="console.log('Selected:', selectedStatus)">
                                                    <select 
                                                    @@click.stop
                                                    @@change.stop
                                                    class="form-control form-control-sm badge badge-sm {{$order->status_badge}}"
                                                    x-model= "selectedStatus"
                                                    @@change= "$dispatch('statusChanged', {id: {{$order->id}}, status: $event.target.value})">
                                                           
                                                            <template x-for= "status in statuses" :key = "status + '-{{$order->id}}'">
                                                                <option :value= "status" x-text= "status" :selected= "status === selectedStatus"></option>
                                                            </template>
                                                    </select> 
                                                </td>
                                                <td class=""> {{$order->created_at}} </td>
                                                <td class=" d-flex justify-content-center align-items-center">
                                                <button x-data="confirmDeleteModal" @@click.stop @@click="confirmDeleteOrder({{$order->id}}, '{{$order->orderID}}')" class="btn btn-danger btn-sm btn-fill py-1 px-3"><i class="fa-solid fa-trash"></i></button>
                                                </td>
                                            </tr>
                                         @endforeach    
                                        </tbody>
                                    </table>
                                </div>
                                <div class="py-4 px-3">
                   
                            </div>
                        </div>
                        </div>
</div>

