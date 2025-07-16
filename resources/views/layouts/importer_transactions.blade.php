<div class="">
    <h2 class="mb-4">Importer Transactions Dashboard</h2>
    <div class="card mb-4 rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
             <div class="card-header">Account Details</div>
             </div>
       
        <div class="card-body">
            @if(isset($account_no) && isset($user))
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        {{-- <div><strong>Total income:</strong> {{ $ }}</div> --}}
                        <div><strong>Account Number:</strong> {{ $account_no }}</div>
                        <div><strong>Account Holder:</strong> {{ $user }}</div>
                
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



      
        <div>
         
            <livewire:importer-transactions />


        </div>
</div>
      