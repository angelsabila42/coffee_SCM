<div class="card col-md-12">
<!--div class="d-flex justify-content-between align-items-center"-->
<div>
  <ul class= "pt-4 nav nav-tabs">
    <li><a href = "#" class="nav-link custom-tab-link {{$activeTab === "Sales" ? 'active' : ''}}" wire:click= "setActiveTab('Sales')">Sales</a></li>
    <li><a href = "#" class="nav-link custom-tab-link {{$activeTab === "Delivery" ? 'active' : ''}}" wire:click= "setActiveTab('Delivery')">Delivery</a></li>
    <li><a href = "#" class="nav-link custom-tab-link {{$activeTab === "QA" ? 'active' : ''}}" wire:click= "setActiveTab('QA')">QA</a></li>
  </ul>
</div>

 <!--div class="d-flex justify-content-end align-items-center pt-4">
    <button class="btn btn-outline-secondary btn-sm" role="Filter" wire:click= "openFilter"><i class="fa-solid fa-filter"></i></button>
    <button  class="btn btn-sm btn-outline-primary" wire:click = "generateReport">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
      </svg>Generate Report
    </button>
  <button class="btn btn-outline-secondary btn-sm" role="settings"><i class="fa-solid fa-gear me-2"></i></button>
</div-->
<!--/div-->

    @if($activeTab === 'Sales')
    <div class = "tab-content">
    <div>
      <!--h4 class = "card-header">Sales</h4-->
        <p class = "card-body pt-0">
          @livewire('sales-report-table')
        </p>
    </div>
    @elseif($activeTab === 'Delivery')
       <div>
      <!--h4 class= "card-header">Delivery</h4-->
        <p class= "card-body pt-0">
          @livewire('delivery-report-table')
        </p>
      </div>
     @elseif($activeTab === 'QA')
       <div>
        <!--h4 class= "card-header">QA</h4-->
        <p class = "card-body pt-0">
          @livewire('q-a-report-table')
        </p>
      </div>
    @endif
</div>
</div>

