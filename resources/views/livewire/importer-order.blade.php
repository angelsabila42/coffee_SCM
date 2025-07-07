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
                    
                   <div  x-data="importerOrderModal" x-init= "init()" x-cloak>
                        <button @@click= "showModal= true" class="btn btn-success btn-fill btn-sm cur"><i class="fa-solid fa-plus pt-1 mr-3"></i>New</button>
                            @include('partials.importer-create-order-modal')
                   </div>
                </div>
                @include('livewire.filters.importer-order-filter') 
            </div>

                            <div class="table-plain-bg">
                                <div class="card-header"></div>
                                <div class="card-body table-full-width table-responsive">
                                <div x-data= "confirmDeleteModal">
                                    <table class="table table-hover" >
                                        <thead class="bg-light">
                                            <th>OrderID</th>
                                            <th>Coffee Type</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Deadline</th>
                                            <th>Date Sent</th>
                                            <th class=" d-flex justify-content-center align-items-center">Actions</th>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr  wire:key= "{{$order->id}}">
                                                <td class=""> {{$order->orderID}} </td>
                                                <td class=""> {{$order->coffeeType}} </td>
                                                <td class=""> {{$order->quantity}} </td>
                                                <td x-data= "{selectedStatus: '{{$order->status}}',
                                                    statuses: ['Requested','Pending', 'Declined', 'Delivered', 'Confirmed' ]}"
                                                    x-init="console.log('Selected:', selectedStatus)">
                                                    <select 
                                                    class="form-control form-control-sm badge badge-sm {{$order->status_badge}}"
                                                    x-model= "selectedStatus"
                                                    @@change= "$dispatch('statusChanged', {id: {{$order->id}}, status: $event.target.value})">
                                                           
                                                            <template x-for= "status in statuses" :key = "status + '-{{$order->id}}'">
                                                                <option :value= "status" x-text= "status" :selected= "status === selectedStatus"></option>
                                                            </template>
                                                    </select> 
                                                </td>
                                                <td class=""> {{$order->deadline}} </td>
                                                <td class=""> {{$order->created_at}} </td>
                                                <td class= "d-flex justify-content-center align-items-center">
                                                <button class="btn btn-danger btn-sm btn-fill py-1 px-3 cur" x-data="confirmDeleteModal" @@click="confirmDeleteOrder({{$order->id}}, '{{$order->orderID}}')">
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

