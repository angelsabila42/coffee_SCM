<div class="modern-card">
        <div class="col-md-12">
            <div x-data="advancedFilter">
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
               
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
                </div>
                @include('partials.advanced-filter')
            </div>

                            <div class="table-plain-bg">
                                <div class="card-body table-full-width table-responsive">
                                <div x-data= "confirmDeleteModal">
                                    <table class="table table-hover" >
                                        <thead class="bg-light">
                                            <th>OrderID</th>
                                            <th>Coffee Type</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Date Sent</th>
                                            <th class=" d-flex justify-content-center align-items-center">Actions</th>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr wire:key= "{{$order->id}}" onclick="window.location= '{{route('vendor.order.show', $order->id)}}' " class="cur">
                                                <td class=""> {{$order->orderID}} </td>
                                                <td class=""> {{$order->coffeeType}} </td>
                                                <td class=""> {{$order->quantity}} </td>
                                                <td x-data= "{selectedStatus: '{{$order->status}}',
                                                    statuses: ['Requested','Pending', 'Cancelled', 'Delivered', 'Confirmed' ]}"
                                                    x-init="console.log('Selected:', selectedStatus)">
                                                    <select
                                                    @@click.stop
                                                    @@change.stop 
                                                    class="form-control form-control-sm badge badge-sm {{$order->status_badge}}"
                                                    x-model= "selectedStatus"
                                                    @@change= "$dispatch('statusChanged', {id: {{$order->id}}, status: $event.target.value})">
                                                           <option :value="selectedStatus">{{$order->status}}</option>
                                                            <template x-for= "status in statuses" :key = "status + '-{{$order->id}}'">
                                                                <option :value= "status" x-text= "status"></option>
                                                            </template>
                                                    </select> 
                                                </td>
                                                <td class=""> {{$order->created_at}} </td>
                                                <td class= "d-flex justify-content-center align-items-center">
                                                <button x-data="confirmDeleteModal" @@click="confirmDeleteOrder({{$order->id}}, '{{$order->orderID}}')" @@click.stop class="btn btn-danger cur btn-sm btn-fill py-1 px-3">
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

