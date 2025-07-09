 <!--cards--> 
<div class="content"> 
<div class="row mb-4">
    <div class="col">
        <div class="card rounded-2 kpi-card ">
            <div class=" d-flex card-body justify-content-between">
                <div>
                {{-- Dynamically get below minimum count--}} 
                <p>Below Minimum</p>
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
                <span class=" text-danger bg-danger-soft stat-icon">
                <i class="fas fa-warehouse"></i>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="modern-tabs mb-5">
    <div class="top-controls">
        <div class="tabs">
           <h3>Inventory</h3>
        </div> 
    </div>
        @extends('layouts.stock_modal')
<div>
<div class="col-md-12">
    {{-- <div class="d-flex justify justify-content-between align-items-center">
        <form method="GET" action="{{url('/inventory')}}"class="mb-3">
            <input type="text" name="search" class="form-control" placeholder="search..."
                value="{{$search ?? ''}}">
        </form> 
    </div> --}}
    <div class="row mt-4">
        <p class="mr-2">Robusta in stock: {{ $robustaStock }} kg</p>
        <p class="ml-2">Arabica in stock: {{ $arabicaStock }} kg</p>    
    </div>
       <livewire:inventory/>
       
    
</div>
</div>
</div>
</div>
