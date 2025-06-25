<div class="container">
    <div class="modern-tabs mb-5">
        <ul class="nav nav-tabs" id="filledTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab">
                        Incoming 
                    </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab">
                        Outgoing 
                    </a>
            </li>
        </ul>
        <div class="tab-content" id="filledTabsContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <h4 class = "card-header">Incoming Orders</h4>
                  <div class = "card-body pt-0">
                    <livewire:incoming-order-table wire:navigate />
                  </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <h4 class= "card-header">Outgoing Orders</h4>
                  <div class= "card-body pt-0">
                    <livewire:outgoing-order-table wire:navigate />
                  </div>
            </div>
        </div>
    </div>
</div>




 







