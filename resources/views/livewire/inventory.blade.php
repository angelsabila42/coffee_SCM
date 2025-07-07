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
                    
                   {{-- <div  x-data="adminOrderModal" x-init= "init()">
                        <button @@click= "showModal= true" class="btn btn-success btn-fill btn-sm cur"><i class="fa-solid fa-plus pt-1 mr-3"></i>New</button>
                            @include('partials.create-order-modal')
                   </div> --}}
                </div>
                @include('partials.advanced-filter') 
            </div>
