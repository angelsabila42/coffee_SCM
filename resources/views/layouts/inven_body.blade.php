 <!--cards--> 
<div class="row mb-4">
    <div class="col">
        <div class="card rounded-2 kpi-card ">
            <div class=" d-flex card-body justify-content-between">
                <div>
                {{-- Dynamically get below minimum count--}} 
                <p>Blelow Minimum</p>
                <h3>{{$belowMinimumCount}}</h3>
                </div>
                <i class="fas fa-exclamation-triangle stat-icon bg-warning-soft"></i> 
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card rounded-2 kpi-card ">
            <div class=" d-flex card-body justify-content-between">
                <div>
                {{-- Dynamically get total quantity count --}}
                <p>Total Stock</p>
                <h3>{{$totalStock}}kg</h3>
                </div>
                <i class="fas fa-boxes text-success stat-icon bg-success-soft"></i>
            </div>
        </div>
    </div>
    <div class="col" >
        <div class="card rounded-2 kpi-card ">
            <div class=" d-flex card-body justify-content-between">
                <div>
                <p>Warehouses</p>
                <h3>{{$totalWarehouses}}</h3>
                </div>
                <i class="fas fa-warehouse"></i>
            </div>
        </div>
    </div>
</div>
<div class="content"> 
    <div class="top-controls">
        <div class="tabs">
           <h3>Inventory</h3>
        </div>
        <div class="right">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addInventoryModal">+New</button>
        </div> 
    </div>
        @extends('layouts.stock_modal')
<div>
<div class="col-md-12">
    <div class="d-flex justify justify-content-between align-items-center">
        <form method="GET" action="{{url('/inventory')}}"class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="search..."
                value="{{$search ?? ''}}">
        </form> 
    </div>
        <p>Robusta in stock: {{ $robustaStock }} kg</p>
        <p>Arabica in stock: {{ $arabicaStock }} kg</p>
    <div class="card card-plain table-plain-bg">
        <div class="card-header ">
        </div>
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
                        <td>{{$item->status}}</td>
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
</div>
</div>
