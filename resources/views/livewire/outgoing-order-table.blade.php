<div>
        <div class="col-md-12">
            <div x-data="advancedFilter">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
               
                    <div class="d-flex flex-wrap align-items-center gap-3">
                    <!--Search bar-->
                        <div class="form mr-3">
                                <span></span><i class="nc-icon nc-zoom-split"></i></span>
                            <input type="text" class="form-control form-input" placeholder="Search" wire:model.live.debounce.250ms= "search"/>
                        </div>

                    <div class="ml-2">
                        <button @@click= "toggle" class="btn btn-light btn-fill btn-sm d-flex align-items-center cur ">
                            <span class="mr-2"><i class='bx bx-filter'></i></span>Filter
                        </button>
                    </div>
                    </div>
                    
                   <div  x-data="adminOrderModal" x-init= "init()">
                        <button @@click= "showModal= true" class="btn btn-success btn-fill btn-sm cur"><i class="fa-solid fa-plus pt-1 mr-3"></i>New</button>
                            @include('partials.create-order-modal')
                   </div>
                </div>
                @include('partials.advanced-filter') 
            </div>

                        <div class="card card-plain table-plain-bg">
                            <div class="card-body table-full-width table-responsive" wire:poll.5s>
                                <div x-data= "confirmDeleteModal">
                                    <table class="table table-hover" >
                                        <thead class="bg-light">
                                            <th>#</th>
                                            <th>OrderID</th>
                                            <th>Vendor Name</th>
                                            <th>Coffee Type</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Deadline</th>
                                            <th>Date Sent</th>
                                            <th class=" d-flex justify-content-center align-items-center">Actions</th>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr wire:key="order-{{ $order->id }}-{{ $order->updated_at }}" onclick="window.location= '{{route('orders.view-vendor-order', $order->id)}}' " class="cur">
                                                <td class=""> {{$order->id}} </td>
                                                <td class=""> {{$order->orderID}} </td>
                                                <td class=""> {{$order->vendorProfile ? $order->vendorProfile->name : 'No vendor'}} </td>
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
                                                           {{-- <option :value="selectedStatus">{{$order->status}}</option> --}}
                                                            <template x-for= "status in statuses" :key = "status + '-{{$order->id}}'">
                                                                <option :value= "status" x-text= "status" :selected= "status === selectedStatus"></option>
                                                            </template>
                                                    </select> 
                                                </td>
                                                <td class=""> {{$order->deadline}} </td>
                                                <td class=""> {{$order->created_at}} </td>
                                                <td class= "d-flex justify-content-center align-items-center">
                                                <button class="btn btn-danger btn-sm btn-fill py-1 px-3 cur" x-data="confirmDeleteModal" @@click.stop  @@click="confirmDeleteOrder({{$order->id}}, '{{$order->orderID}}')" {{--@@click= "$dispatch('open-delete-modal', {id:{{$order->id}}})"--}}>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                </td>
                                            </tr>
                                         @endforeach    
                                        </tbody>
                                    </table>

                                </div>
                                
                            </div>
                                @once
                                 <livewire:confirm-delete-modal/>
                                @endonce
                        </div>
                    </div>
            {{$orders->links()}}      
</div>
