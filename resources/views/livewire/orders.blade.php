<x-tabs :tabs="[ 'incoming' => 'Incoming Orders',
            'outgoing' => 'Outgoing Orders',]" />



{{-- <div x-data="{activeTab: localStorage.getItem('tab') || 'incoming'}"
     x-init= "$watch('activeTab', val=> localStorage.setItem('tab', val))" class="container">
    <div class="modern-tabs mb-5">
        <ul class="nav nav-tabs" id="filledTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                   :class="{'active': activeTab === 'incoming'}"
                   @@click= "activeTab = 'incoming'"
                    href="#incoming-order"
                    role="tab">
                        Incoming 
                    </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                   :class="{'active': activeTab === 'outgoing'}"
                    @@click= "activeTab = 'outgoing'"
                    href="#outgoing-order"
                    role="tab">
                        Outgoing 
                    </a>
            </li>
        </ul>
        <div class="tab-content" id="filledTabsContent">
            <div class="tab-pane fade "
                 :class="{'show active': activeTab === 'incoming'}"
                 role="tabpanel">
                <h4 class = "card-header">Incoming Orders</h4>
                  <div class = "card-body pt-0">
                    <livewire:incoming-order-table/>
                  </div>
            </div>
            
            <div class="tab-pane fade"
                 :class="{'show active': activeTab === 'outgoing'}"
                 role="tabpanel">
                <h4 class= "card-header">Outgoing Orders</h4>
                  <div class= "card-body pt-0">
                    <livewire:outgoing-order-table/>
                  </div>
            </div>
        </div>
    </div>
</div>




 






 --}}
