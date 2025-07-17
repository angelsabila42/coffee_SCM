<div class="col-md-12">
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

                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addWorkAssignmentModal">
                      + New
                   </button>
                    
                 
                </div>
                
            </div>
            </div>
