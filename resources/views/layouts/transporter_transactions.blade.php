<div class=" ">
    <h2 class="mb-4">Transporter Transactions Dashboard</h2>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
             <div class="card-header">Account Details</div>
             {{-- <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#edit_modal">Edit</button> --}}
        </div>
       
        <div class="card-body">
            @if($invoices->count())
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        {{-- <div><strong>Total income:</strong> {{ $invoices->first()->vendor_name }}</div> --}}
                        {{-- <div><strong>Account Number:</strong> {{ $invoices->first()->bank_account_no }}</div>
                        <div><strong>Account Holder:</strong> {{ $invoices->first()->bank_name }}</div>
                
                    </div>
                    <div data-bs-toggle="dropdown" aria-expanded="false" class="dropdown">
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Bank Transfer</a></li>
                            <li><a class="dropdown-item" href="#">Mobile Money</a></li>
                            <li><a class="dropdown-item" href="#">Cash</a></li>
                    </div>

                </div> --}}
                @else
                <div>No account details available.</div>
            @endif
        </div>
    </div>

     <div>
        @livewire('transporter-transactions')
     </div>


</div>

