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
                    
                <div>
                    <button type="button" class="btn btn-success btn-fill" data-bs-toggle="modal" data-bs-target="#addInventoryModal">+New</button>
                </div>
                </div>
                @include('partials.inventory-filter')

                <div class="card card-plain table-plain-bg">
        <div class="card-body table-full-width table-responsive">
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th class="font-weight-bold" style="text-transform: none">id</th>
                        <th class="text-amber" style="text-transform: none">coffee_type</th>
                        <th style="text-transform: none" >grade</th>
                        <th style="text-transform: none">warehouse_name</th>
                        <th style="text-transform: none">quantity</th>
                        <th style="text-transform: none">threshold</th>
                        <th style="text-transform: none">status</th>
                        <th style="text-transform: none">last_updated</th>
                        <th style="text-transform: none">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventories as $item)
                    <tr onclick = "window.location='{{route('stock', $item->id)}}'">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->coffee_type}}</td>
                        <td>{{$item->grade}}</td>
                        <td>{{$item->warehouse_name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->threshold}}</td>
                        <td>
                            @if($item->quantity < $item->threshold)
                               <span class="badge bg-danger">Low</span>
                            @else 
                               <span class="badge bg-success">In Stock</span>
                            @endif
                        </td>
                        <td>{{$item->last_updated}}</td>
                        <td>
                            <form action="{{route('inventory.destroy', $item->id)}}"
                               method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-fill py-1 px-3"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                                           
                                            
                </tbody>
            </table>
        </div>
        {{ $inventories->links('pagination::bootstrap-5') }}
    </div>
</div>

