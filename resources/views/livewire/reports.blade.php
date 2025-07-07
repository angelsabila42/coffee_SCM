<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <ul class="nav nav-tabs" id="reportTabs" role="tablist">
                <li class="nav-item">
                    <a href="#" class="nav-link {{$activeTab === 'Sales' ? 'active' : ''}}" wire:click="setActiveTab('Sales')">Sales</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{$activeTab === 'Delivery' ? 'active' : ''}}" wire:click="setActiveTab('Delivery')">Delivery</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{$activeTab === 'QA' ? 'active' : ''}}" wire:click="setActiveTab('QA')">QA</a>
                </li>
  </ul>
            <div class="input-group input-group-sm ml-3" style="width: 150px;">
                <input type="text" name="table_search" class="form-control" placeholder="Search">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
</div>
        <div>
            <button class="btn btn-sm btn-outline-primary" wire:click="generateReport">
                <i class="bi bi-plus-circle me-2"></i> Generate Report
    </button>
            <button class="btn btn-outline-secondary btn-sm ml-2" wire:click="openFilter"><i class="fa-solid fa-filter"></i></button>
            <button class="btn btn-outline-secondary btn-sm ml-2"><i class="fa-solid fa-gear me-2"></i></button>
        </div>
    </div>
    <div class="card-body">
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

