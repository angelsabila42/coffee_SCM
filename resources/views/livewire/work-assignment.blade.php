<div class="col-md-12">
    <div x-data="{ filterOpen: false }" class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <!--Search bar-->
                    <div class="form mr-3">
                        <span><i class="nc-icon nc-zoom-split"></i></span>
                        <input type="text" class="form-control form-input" placeholder="Search" wire:model.live.debounce.250ms="search"/>
                    </div>

                    <div class="ml-2">
                        <button @click="filterOpen = !filterOpen" class="btn btn-light btn-fill btn-sm d-flex align-items-center">
                            <span class="mr-2"><i class='bx bx-filter'></i></span>Filter
                        </button>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addWorkAssignmentModal">
                    + New
                </button>
            </div>

            <!-- Filter Panel -->
            <div x-show="filterOpen" x-transition class="mt-3">
                @include('livewire.filters.work-assignment-filter')
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Staff Name</th>
                            <th>Coffee Type</th>
                            <th>Quantity</th>
                            <th>Work Center</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workAssignments as $assignment)
                        <tr>
                            <td>{{ $assignment->id }}</td>
                            <td>{{ $assignment->staff->full_name }}</td>
                            <td>{{ $assignment->coffeeType }}</td>
                            <td>{{ $assignment->quantity }}</td>
                            <td>{{ $assignment->workCenter->name }}</td>
                            <td>{{ $assignment->start_date }}</td>
                            <td>{{ $assignment->end_date }}</td>
                            <td>
                                <span class="badge {{ $assignment->status === 'completed' ? 'bg-success' : ($assignment->status === 'in_progress' ? 'bg-warning' : 'bg-secondary') }}">
                                    {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" title="Edit"
                                    wire:click="edit({{ $assignment->id }})">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $workAssignments->links() }}
            </div>
        </div>
    </div>
</div>
