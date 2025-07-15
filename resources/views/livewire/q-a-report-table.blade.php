<div>
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!--Search bar-->
            <div class="d-flex align-items-center">
                <div class="form">
                    <i class="nc-icon nc-zoom-split"></i>
                    <input wire:model.live="search" type="text" class="form-control form-input" placeholder="Search">
                </div>
            </div>
            
            <div>
                <a href="{{ route('qa.create') }}" class="btn btn-primary btn-sm">
                    + New
                </a>
            </div>
        </div>
                
        <!--Table-->
        <div class="card card-plain table-plain-bg">
            <div class="card-body table-full-width table-responsive">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ReportID</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->reportID }}</td>
                            <td>{{ $report->date ? $report->date->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('qa.show', $report) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <form action="{{ route('qa.destroy', $report) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this.form, '{{ $report->reportID }}')" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No QA reports found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

