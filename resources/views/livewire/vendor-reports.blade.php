<div class="container py-4">
    <h2 class="mb-4">Vendor Reports</h2>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'sales' ? 'active' : '' }}" href="#" wire:click.prevent="setActiveTab('sales')">Sales Report</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'delivery' ? 'active' : '' }}" href="#" wire:click.prevent="setActiveTab('delivery')">Delivery Report</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'payment' ? 'active' : '' }}" href="#" wire:click.prevent="setActiveTab('payment')">Payment Report</a>
        </li>
    </ul>
    <div class="card">
        <div class="card-body">
            @if($activeTab === 'sales')
                <a href="{{ route('reports.sales.csv') }}" class="btn btn-success mb-2">Download CSV</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Vendor</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->vendor_name }}</td>
                                <td>{{ $invoice->status }}</td>
                                <td>{{ $invoice->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif($activeTab === 'delivery')
                <a href="{{ route('reports.delivery.csv') }}" class="btn btn-success mb-2">Download CSV</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Delivery ID</th>
                            <th>Date Ordered</th>
                            <th>Destination</th>
                            <th>Status</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveries as $delivery)
                            <tr>
                                <td>{{ $delivery->delivery_id }}</td>
                                <td>{{ $delivery->date_ordered }}</td>
                                <td>{{ $delivery->delivery_destination }}</td>
                                <td>{{ $delivery->status }}</td>
                                <td>{{ $delivery->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif($activeTab === 'payment')
                <a href="{{ route('reports.payment.csv') }}" class="btn btn-success mb-2">Download CSV</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Receipt #</th>
                            <th>Date Paid</th>
                            <th>Payer</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->receipt_number }}</td>
                                <td>{{ $payment->date_paid }}</td>
                                <td>{{ $payment->payer }}</td>
                                <td>{{ $payment->amount_paid }}</td>
                                <td>{{ $payment->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div> 