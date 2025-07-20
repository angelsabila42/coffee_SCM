<div >
    {{-- Tabs --}}
    <div class="card mb-3">
         <ul class="nav nav-pills m-3">
        {{-- <li class="nav-item">
            <a href="#" wire:click.prevent="$set('tab', 'invoices')" class="nav-link {{ $tab === 'invoices' ? 'active bg-primary text-white' : '' }}">Invoices</a>
        </li> --}}
        <li class="nav-item">
            <a href="#" wire:click.prevent="$set('tab', 'payments')" class="nav-link active text-white bg-primary">Payments</a>
        </li>
    </ul>

    


    <div class="d-flex flex-wrap gap-2 mb-3 ">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..." class="form-control m-3" style="max-width: 250px;">

        <select wire:model.live="status" class="form-select m-3" style="max-width: 200px;">
            <option value="">All Statuses</option>
            <option value="partial" >partial</option>
            <option value="pending">Pending</option>
            <option value="Completed">Completed</option>
        </select>

        {{-- @if ($tab === 'payments') --}}
        <select wire:model.live="coffeeType" class="form-select m-3" style="max-width: 200px;">
            <option value="">All Coffee Types</option>
            <option value="robusta">Robusta</option>
            <option value="arabicca">Arabicca</option>
        </select>

        <select wire:model.live="paymentMode" class="form-select m-3" style="max-width: 200px;">
            <option value="">All Payment Modes</option>
            <option value="Cash">Cash</option>
            <option value="Mobile Money">Mobile Money</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select>
        {{-- @endif --}}
    </div>

    {{-- Table --}}
    <div class="  table-plain-bg">
        <table class="table table-hover table-responsive fw-bold fs-5">
            <thead>
                {{-- @if ($tab === 'invoices')
                <tr>
                    <th>InvoiceID</th>
                    <th>Issued on</th>
                    <th>OrderID</th>
                    <th>Amount Due</th>
                    <th>Due date</th>
                    <th>Status</th>
                </tr>
                @else --}}
                <tr>
                    <th>InvoiceID</th>
                    <th>Payer</th>
                    <th>Amount Paid</th>
                    <th>Date Paid</th>
                    <th>Payment Mode</th>
                    <th>Status</th>
                    <th>Coffee Type</th>
                    <th>Recipient Name</th>
                </tr>
                {{-- @endif --}}
            </thead>
            <tbody>
                @forelse($records as $record)
                @php
                                        
                            $class = '';
                            if ($record->status == 'partial'){
                                $class = 'bg-primary';
                            }
                             elseif ($record->status == 'Pending'){
                                $class = 'bg-warning';
                            }
                           
                             else $class = 'bg-success';
                    

                @endphp
                    {{-- @if ($tab === 'invoices')
                        <tr>
                            <td>{{ $record->invoice_number }}</td>
                            <td>{{ $record->invoice_date }}</td>
                            <td>{{ $record->id }}</td>
                            <td>{{ $record->sub_total }}</td>
                            <td>{{ $record->updated_at }}</td>
                            <td>{{ $record->status }}</td>
                        </tr>
                    @else --}}
                    {{-- onclick="window.location='{{ route('TransPayments.show', $record->id) }}'" --}}
                        <tr 
                                 style="cursor: pointer;">
                            <td >{{ $record->invoice_id }}</td>
                            <td>{{ $record->payer }}</td>
                            <td>{{ $record->amount_paid }}</td>
                            <td>{{ $record->date_paid }}</td>
                            <td>{{ $record->payment_mode }}</td>
                            <td class="{{ $class }} text-white badge w-100">{{ $record->status }}</td>
                            <td>{{ $record->coffee_type }}</td>
                            <td>{{ $record->recipient_name }}</td>
                        </tr>
                    {{-- @endif --}}
                @empty
                    <tr>
                        <td  class="text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $records->links() }}
    </div>
    </div>
   
</div>

