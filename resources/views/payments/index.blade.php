@extends('layouts.app')

@section('page-title', 'Payment Records')
@section('sidebar-items')
@include('layouts.sidebar-items.admin')
@endsection

@section('sidebar-item')
@include('layouts.sidebar-items.admin')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Transactions</h4>
        <div class="d-flex align-items-center">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control" placeholder="Search">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm ml-2"><i class="nc-icon nc-simple-add"></i> New</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Payment #</th>
                    <th>Date</th>
                    <th>Coffee Type</th>
                    <th>Recipient</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->receipt_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->date_paid)->format('d M, Y:i A') }}</td>
                        <td>{{ $payment->coffee_type }}</td>
                        <td>{{ $payment->recipient_name }}</td>
                        <td>Ugx {{ number_format($payment->amount_paid, 2) }}</td>
                        <td>{{ $payment->payment_description }}</td>
                        <td>{{ $payment->status }}</td>
                        <td>
                            <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info btn-sm action-btn">View</a>
                            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm action-btn">Edit</a>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm action-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        {{ $payments->links() }} {{-- Pagination links --}}
    </div>
</div>
@endsection