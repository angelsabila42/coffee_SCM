<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #8B4513; font-weight: 700;">My Orders</h2>
        <div>
            <button class="btn" onclick="window.location.reload()" style="background-color: #8B4513; color: white; border-radius: 20px;">
                <i class="bx bx-refresh"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-search"></i> Search & Filter Orders
            </h5>
        </div>
        <div class="card-body">
            <div x-data="advancedFilter">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #F5F5DC; border-color: #F5F5DC;">
                                        <i class="bx bx-search" style="color: #8B4513;"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Search orders..." 
                                       wire:model.live.debounce.250ms="search"
                                       style="border: 2px solid #F5F5DC; border-left: none;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button @click="toggle" class="btn" style="background-color: #CD853F; color: white; border-radius: 20px;">
                            <i class="bx bx-filter"></i> Advanced Filter
                        </button>
                    </div>
                </div>
                @include('partials.advanced-filter')
            </div>
        </div>
    </div>
                            <div class="table-plain-bg">
                                <div class="card-body table-full-width table-responsive">
                                <div x-data= "confirmDeleteModal">
                                    <table class="table table-hover" >
                                        <thead class="bg-light">
                                            <th>#</th>
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
                                                <td class= "d-flex justify-content-center align-items-center">
                                                <button class="btn btn-danger btn-sm btn-fill py-1 px-3 cur" x-data="confirmDeleteModal" @@click="confirmDeleteOrder({{$order->id}}, '{{$order->orderID}}')" @@click.stop>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                </td>
                                            </tr>
                                         @endforeach    
                                        </tbody>
                                    </table>
    <!-- Orders Table -->
    {{-- <div class="card" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <h5 class="mb-0">
                <i class="bx bx-list-ul"></i> Orders Management
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div x-data="confirmDeleteModal">
                    <table class="table table-striped">
                        <thead style="background-color: #F5F5DC;">
                            <tr>
                                <th style="color: #8B4513; font-weight: 600;">Order ID</th>
                                <th style="color: #8B4513; font-weight: 600;">Coffee Type</th>
                                <th style="color: #8B4513; font-weight: 600;">Quantity</th>
                                <th style="color: #8B4513; font-weight: 600;">Status</th>
                                <th style="color: #8B4513; font-weight: 600;">Date Sent</th>
                                <th style="color: #8B4513; font-weight: 600;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr wire:key="{{$order->id}}" onclick="window.location='{{route('vendor.order.show', $order->id)}}'" 
                                style="cursor: pointer;" class="hover-row">
                                <td><strong style="color: #8B4513;">{{$order->orderID}}</strong></td>
                                <td>{{$order->coffeeType}}</td>
                                <td>{{$order->quantity}} kg</td>
                                <td x-data="{selectedStatus: '{{$order->status}}',
                                    statuses: ['Requested','Pending', 'Cancelled', 'Delivered', 'Confirmed']}"
                                    x-init="console.log('Selected:', selectedStatus)">
                                    <select 
                                    @click.stop
                                    @change.stop
                                    class="form-control form-control-sm {{$order->status_badge}}"
                                    x-model="selectedStatus"
                                    @change="$dispatch('statusChanged', {id: {{$order->id}}, status: $event.target.value})"
                                    style="border-radius: 15px; font-size: 0.8em; padding: 0.4em 0.8em;">
                                        @foreach(['Requested','Pending', 'Cancelled', 'Delivered', 'Confirmed'] as $status)
                                            <option value="{{$status}}" :selected="selectedStatus === '{{$status}}'">{{$status}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{route('vendor.order.show', $order->id)}}" 
                                           class="btn btn-sm" onclick="event.stopPropagation();"
                                           style="background-color: #CD853F; color: white; border-radius: 15px; margin-right: 5px;">
                                            <i class="bx bx-eye"></i> View
                                        </a>
                                        @if($order->status !== 'Delivered' && $order->status !== 'Cancelled')
                                        <button class="btn btn-sm" onclick="event.stopPropagation(); editOrder({{$order->id}})"
                                                style="background-color: #A0522D; color: white; border-radius: 15px;">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                        @endif --}}
                                    {{-- </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div style="color: #8B4513;">
                                        <i class="bx bx-package" style="font-size: 3rem; opacity: 0.5;"></i>
                                        <p class="mt-2">No orders found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table> --}}
                {{-- </div>
            </div>
        </div>
    </div> --}}
</div>
</div>
</div>
</div>

