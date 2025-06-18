@extends('layouts.app')

@section('page-title', 'Exporter\'s Invoices')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Invoices</h4>
        <div class="d-flex align-items-center">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control" placeholder="Search">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm ml-2"><i class="nc-icon nc-simple-add"></i> New</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Order Date</th>
                    <th>Phone Number</th>
                    <th>Recipient</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y:i A') }}</td>
                        <td>{{ $invoice->recipient_phone }}</td>
                        <td>{{ $invoice->bill_to_name }}</td>
                        <td>{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</td>
                        <td>{{ $invoice->purpose }}</td>
                        <td>{{ $invoice->status }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        {{ $invoices->links() }} {{-- Pagination links --}}
    </div>
</div>
@endsection 