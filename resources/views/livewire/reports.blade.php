<div class="container py-4">
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <h3 class="mb-4 font-weight-bold" style="color:#222">Reports</h3>
            <div class="d-flex flex-wrap align-items-center mb-3 justify-content-between">
                <div class="d-flex flex-wrap align-items-center">
                    <ul class="nav nav-tabs modern-tabs mb-0" id="reportTabs" role="tablist">
                        <li class="nav-item">
                            <a href="#" class="nav-link font-weight-bold {{$activeTab === 'Sales' ? 'active' : ''}}" wire:click="setActiveTab('Sales')" style="color:#6c757d;{{ $activeTab === 'Sales' ? 'background:#e5ded7;' : '' }}">Sales</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link font-weight-bold {{$activeTab === 'Delivery' ? 'active' : ''}}" wire:click="setActiveTab('Delivery')" style="color:#6c757d;{{ $activeTab === 'Delivery' ? 'background:#e5ded7;' : '' }}">Delivery</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link font-weight-bold {{$activeTab === 'QA' ? 'active' : ''}}" wire:click="setActiveTab('QA')" style="color:#6c757d;{{ $activeTab === 'QA' ? 'background:#e5ded7;' : '' }}">QA</a>
                        </li>
                    </ul>
                    <div class="form ml-3 position-relative">
                        <span class="position-absolute" style="left:10px;top:8px;color:#aaa;"><i class="nc-icon nc-zoom-split"></i></span>
                        <input type="text" class="form-control pl-4" placeholder="Search" style="width:200px;">
                    </div>
                    <button class="btn btn-light btn-fill btn-sm d-flex align-items-center ml-2" style="color:#6c757d;">
                        <span class="mr-2"><i class='bx bx-filter'></i></span>Filter
                    </button>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-primary" wire:click="generateReport">
                        <i class="bi bi-plus-circle me-2"></i> Generate Report
                    </button>
                    <button class="btn btn-outline-secondary btn-sm ml-2" wire:click="openFilter"><i class="fa-solid fa-filter"></i></button>
                    <button class="btn btn-outline-secondary btn-sm ml-2"><i class="fa-solid fa-gear me-2"></i></button>
                </div>
            </div>
            <div class="tab-content" id="reportTabsContent">
                @if($activeTab === 'Sales')
                    <div class="tab-pane fade show active" id="sales" role="tabpanel">
                        @livewire('sales-report-table')
                    </div>
                @elseif($activeTab === 'Delivery')
                    <div class="tab-pane fade show active" id="delivery" role="tabpanel">
                        @livewire('delivery-report-table')
                    </div>
                @elseif($activeTab === 'QA')
                    <div class="tab-pane fade show active" id="qa" role="tabpanel">
                        @livewire('q-a-report-table')
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

