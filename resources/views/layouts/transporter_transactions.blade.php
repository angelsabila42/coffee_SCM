<div class="container py-4">
    <h2 class="mb-4">Transporter Transactions Dashboard</h2>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
             <div class="card-header">Account Details</div>
             <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</button>
        </div>
       
        <div class="card-body">
            @if($invoices->count())
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div><strong>Total income:</strong> {{ $invoices->first()->vendor_name }}</div>
                        <div><strong>Account Number:</strong> {{ $invoices->first()->bank_account_no }}</div>
                        <div><strong>Account Holder:</strong> {{ $invoices->first()->bank_name }}</div>
                
                    </div>
                    <div data-bs-toggle="dropdown" aria-expanded="false" class="dropdown">
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Bank Transfer</a></li>
                            <li><a class="dropdown-item" href="#">Mobile Money</a></li>
                            <li><a class="dropdown-item" href="#">Cash</a></li>
                    </div>

                </div>
                @else
                <div>No account details available.</div>
            @endif
        </div>
    </div>



      <div class="card mb-4">
    <div class="card-header bg-white border-0">
        <h5 class="mb-0">Payments and Billing</h5>
    </div>
    <div class="card-body pt-3 pb-0">
        <div class="">

         <ul class="nav nav-pills nav-justified mb-3 rounded-pill bg-light p-1 text-white" id="pills-tab" role="tablist" style="max-width: 400px; ">
            <li class="nav-item" role="presentation">
                <button class=" bg-primary p-1 text-white nav-link active rounded-start-5" id="invoices-tab" data-bs-toggle="pill" data-bs-target="#invoices" type="button" role="tab" aria-controls="invoices" aria-selected="true">
                    Invoices
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-end-5 bg-white p-1 text-primary" id="payments-tab" data-bs-toggle="pill" data-bs-target="#payments" type="button" role="tab" aria-controls="payments" aria-selected="false">
                    Payments
                </button>
            </li>
           </ul>
        
        </div>
       <div class="tab-content">
            <div class="tab-pane fade show active" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                {{-- Invoices Table --}}
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>InvoiceID</th>
                                <th>Issued on</th>
                                <th>OrderID</th>
                                <th>Amount Due</th>
                                <th>Due date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ $invoice->sub_total }}</td>
                                    <td>{{ $invoice->updated_at }}</td>
                                    <td>{{ $invoice->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                {{-- Payments Table --}}
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
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
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->invoice_id }}</td>
                                    <td>{{ $payment->payer }}</td>
                                    <td>{{ $payment->amount_paid }}</td>
                                    <td>{{ $payment->date_paid }}</td>
                                    <td>{{ $payment->payment_mode }}</td>
                                    <td>{{ $payment->status }}</td>
                                    <td>{{ $payment->coffee_type }}</td>
                                     <td>{{ $payment->recipient_name }}</td>
                                    {{-- <td>
                                        @if($payment->receipt_file_path)
                                            <a href="{{ asset('storage/' . $payment->receipt_file_path) }}" class="btn btn-sm btn-success" target="_blank">Download</a>
                                        @else
                                            N/A
                                        @endif
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tabButtons = document.querySelectorAll('#pills-tab .nav-link');
                tabButtons.forEach(butn => {
                    butn.addEventListener('click', function () {
                        tabButtons.forEach(b => b.classList.remove('bg-primary', 'text-white', 'bg-white', 'text-primary', 'active'));
                        this.classList.add('bg-primary', 'text-white', 'active');
                        this.classList.remove('bg-white', 'text-primary');
                        tabButtons.forEach(b => {
                            if (b !== this) {
                                b.classList.add('bg-white', 'text-primary');
                                b.classList.remove('bg-primary', 'text-white', 'active');
                            }
                        });
                    });
                });
            });
            </script>

            <div  id="edit_modal" class="modal fade" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="" method="POST" class="modal-content">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="modal-header">
                            <h4>Edit account details</h4>
                            <button class="btn-close" data-bs-dismiss="modal"  ></button>

                        </div>
                        <div class="modal-body">
                            <h5 class="form-label fw-bold " >enter account number</h5>
                             <input type="text" class="form-control" name="" value="">
                            <h5 class="form-label">enter your age</h5>
                            <input type="text" class="form-control" name="" value="">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">
                                save changes
                            </button>
                            <button class="btn btn-info" data-bs-dismiss="modal" type="button">
                                cancel
                            </button>
                            
                        </div>
                    </form>
                </div>
            </div>
    {{-- <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'invoices' ? 'active' : '' }}" href="#" wire:click.prevent="setActiveTab('invoices')">Invoices</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'payments' ? 'active' : '' }}" href="#" wire:click.prevent="setActiveTab('payments')">Payments</a>
        </li>
    </ul> --}}
    {{-- @if($activeTab === 'invoices') --}}
      {{-- @if($activeTab === 'invoices') --}}
    {{-- <div class="card">
        <div class="d-flex">
            <span class=" w-25 rounded-circle">Invoices</span>
            <span class=" ms-3 w-25 rounded-circle">Payments</span>
        </div>
    </div>


        <div class="card">
            <div class="card-header">Invoices</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>InvoiceID</th>
                            <th>issued on</th>
                            <th>OrderID</th>
                            <th>Amount Due</th>
                            <th>Due date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->sub_total }}</td>
                                <td>{{ $invoice->updated_at }}</td>
                                <td>{{ $invoice->status }}</td>
                             
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
    {{-- @elseif($activeTab === 'payments') --}}
        {{-- <div class="card">
            <div class="card-header">Payments</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Receipt #</th>
                            <th>Invoice #</th>
                            <th>Payer</th>
                            <th>Amount Paid</th>
                            <th>Date Paid</th>
                            <th>Payment Mode</th>
                            <th>Status</th>
                            <th>Coffee Type</th>
                            <th>Description</th>
                            <th>Recipient Name</th>
                            <th>Receipt File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->receipt_number }}</td>
                                <td>{{ optional($payment->invoice)->invoice_number }}</td>
                                <td>{{ $payment->payer }}</td>
                                <td>{{ $payment->amount_paid }}</td>
                                <td>{{ $payment->date_paid }}</td>
                                <td>{{ $payment->payment_mode }}</td>
                                <td>{{ $payment->status }}</td>
                                <td>{{ $payment->coffee_type }}</td>
                                <td>{{ $payment->payment_description }}</td>
                                <td>{{ $payment->recipient_name }}</td> --}}
                                {{-- <td>
                                    @if($payment->receipt_file_path)
                                        <a href="{{ asset('storage/' . $payment->receipt_file_path) }}" class="btn btn-sm btn-success" target="_blank">Download</a>
                                    @else
                                        N/A
                                    @endif
                                </td> --}}
                            </tr>
                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    {{-- @endif --}}
</div>
{{-- @if($showInvoiceItemsModal)
<div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invoice Items for #{{ $selectedInvoiceNumber }}</h5>
                <button type="button" class="close" wire:click="closeInvoiceItemsModal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedInvoiceItems as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->unit_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" wire:click="closeInvoiceItemsModal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif  --}}