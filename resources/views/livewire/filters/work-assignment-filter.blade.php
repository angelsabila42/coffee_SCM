<div  x-show="showFilter" class="mt-3 p-3" x-cloak x-transition>
    <div class="row align-items-center">
        <div class="col-md-4">
            <div class="form-group mb-2">
                <label for="role" class="mr-2 filter-dropdown">Role:</label>
                <select wire:model.live.debounce.500ms="role" class="form-control">
                    <option value="">All</option>
                    <option value="Logistics Supervisor">Logistics Supervisor</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Warehouse Clerk">Warehouse Clerk</option>
                    <option value="QA">QA</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-2">
                <label for="date_range" class="mr-2 filter-dropdown">Date Range:</label>
                <div class="d-flex gap-2">
                    <input type="date" wire:model.live.debounce.500ms="startDate" class="form-control" placeholder="Start Date">
                    <input type="date" wire:model.live.debounce.500ms="endDate" class="form-control" placeholder="End Date">
                </div>
            </div>
        </div>
        <div class="col-auto mt-4">
            <button class="btn btn-secondary btn-sm cur" wire:click="clearFilter">Clear Filters</button>
        </div>
    </div>
</div>
