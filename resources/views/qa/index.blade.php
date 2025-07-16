@extends('layouts.app')

@section('content')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Quality Assessment Reports</h2>
            </div>
            <livewire:q-a-report-table />
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(reportId, reportNumber) {
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 is not loaded');
            return;
        }
        
        Swal.fire({
            title: 'Delete Report?',
            text: `Are you sure you want to delete QA Report ${reportNumber}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + reportId).submit();
            }
        });
    }
</script>
@endpush
@endsection
