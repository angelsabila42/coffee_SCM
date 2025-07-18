<div >
    {{-- Header --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-credit-card text-primary me-2"></i>
                        Payment Transactions
                    </h4>
                    <p class="text-muted mb-0">Manage and view your PesaPal payment history</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">Total Transactions: {{ $records->total() }}</small>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex flex-wrap gap-2 mb-3">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search transactions..." class="form-control" style="max-width: 250px;">

        <select wire:model.live="paymentMethod" class="form-select" style="max-width: 200px;">
            <option value="">All Payment Methods</option>
            <option value="Mobile Money">Mobile Money</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
        </select>
        
        <button wire:click="clearFilters" class="btn btn-outline-secondary">
            <i class="fas fa-times"></i> Clear Filters
        </button>
    </div>

    {{-- Table --}}
    <div class="card card-plain table-plain-bg">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-credit-card text-primary me-2"></i>
                PesaPal Payment Transactions
            </h5>
            <small class="text-muted">Your payment history and transaction records</small>
        </div>
        <div class="table-responsive">
            <table class="table table-hover fw-bold fs-6">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Payment Method</th>
                        <th>Order Count</th>
                    </tr>
                </thead>
            <tbody>
                @forelse($records as $record)
                    <tr class="table-row">
                        <td>
                            <strong>{{ $record->pesapal_merchant_reference }}</strong>
                            @if($record->pesapal_tracking_id)
                                <br><small class="text-muted">Track: {{ $record->pesapal_tracking_id }}</small>
                            @endif
                        </td>
                        <td>{{ $record->description ?? 'Payment for coffee orders' }}</td>
                        <td>
                            <strong class="text-success">UGX {{ number_format($record->total_amount, 2) }}</strong>
                        </td>
                        <td>
                            @if($record->payment_date)
                                {{ $record->payment_date->format('M d, Y') }}
                                <br><small class="text-muted">{{ $record->payment_date->format('h:i A') }}</small>
                            @else
                                <span class="text-muted">{{ $record->created_at->format('M d, Y') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($record->payment_method)
                                <span class="badge bg-info">{{ $record->payment_method }}</span>
                            @else
                                <span class="text-muted">PesaPal</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                {{ is_array($record->order_ids) ? count($record->order_ids) : 0 }} order(s)
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-credit-card fa-3x mb-3" style="opacity: 0.3;"></i>
                                <h5>No payment records found</h5>
                                <p>Your payment transactions will appear here once you make payments through PesaPal.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $records->links() }}
    </div>

    {{-- Styles --}}
    <style>
    .table-row:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }

    .badge {
        font-weight: 500;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
    }
    </style>
</div>
