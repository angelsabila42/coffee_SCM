
<div class="col-md-12">
    <div x-data="{ showFilter: false }" wire:init>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!--Search bar-->
                <div class="form mr-3">
                    <span><i class="nc-icon nc-zoom-split"></i></span>
                    <input type="text" class="form-control form-input" placeholder="Search by staff, role, or work center" wire:model.live.debounce.250ms="search"/>
                </div>
                <div class="ml-2">
                    <button @click="showFilter = !showFilter" class="btn btn-light btn-fill btn-sm d-flex align-items-center cur">
                        <span class="mr-2"><i class='bx bx-filter'></i></span>Filter
                    </button>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addWorkAssignmentModal">
                + New
            </button>
        </div>
        <!-- Filter Panel -->
        <div x-show="showFilter" class="mt-3 p-3 card" x-cloak x-transition>
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label for="role" class="mr-2 filter-dropdown">Role:</label>
                        <select wire:model.live.debounce.500ms="role" class="form-control">
                            <option value="">All Roles</option>
                            @foreach($roles as $roleOption)
                                <option value="{{ $roleOption }}">{{ $roleOption }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label for="work_center" class="mr-2 filter-dropdown">Work Center:</label>
                        <select wire:model.live.debounce.500ms="work_center" class="form-control">
                            <option value="">All Work Centers</option>
                            @foreach($workCenters as $center)
                                <option value="{{ $center->id }}">{{ $center->centerName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-auto mt-4">
                    <button class="btn btn-secondary btn-sm" wire:click="clearFilter">Clear Filters</button>
                </div>
            </div>
        </div>
        <!-- Results info -->
        @if($search || $role || $work_center)
            <div class="mt-3 mb-3">
                <small class="text-muted">
                    Showing {{ $workAssignments->count() }} results
                    @if($search) with search "{{ $search }}" @endif
                    @if($role) in role "{{ $role }}" @endif
                    @if($work_center) for work center ID "{{ $work_center }}" @endif
                </small>
            </div>
        @endif
    </div>
</div>
