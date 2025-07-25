<div class="container-fluid">
    <h2 class="mb-4" style="color: #8B4513; font-weight: 700;">Transactions</h2>
    
    <div class="card mb-4" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #8B4513; color: white; border-radius: 10px 10px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-credit-card"></i> Account Details
                </h5>
                {{-- <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" style="border-radius: 15px;">
                    <i class="bx bx-edit"></i> Edit
                </button> --}}
            </div>
        </div>
       
        <div class="card-body" style="background-color: #FAFAFA;">
            @if(@isset($account_no )&& @isset($user))
                
            
                <div class="d-flex justify-content-between align-items-center mb-3">
                    {{-- <div>
                        <div class="mb-2">
                            <i class="bx bx-building" style="color: #8B4513;"></i>
                            <strong style="color: #8B4513;">Company:</strong> {{ Auth::user()->name ?? 'Not Available' }}
                        </div>
                        <div class="mb-2">
                            <i class="bx bx-envelope" style="color: #8B4513;"></i>
                            <strong style="color: #8B4513;">Email:</strong> {{ Auth::user()->email ?? 'Not Available' }}
                        </div>
                        <div class="mb-2">
                            <i class="bx bx-calendar" style="color: #8B4513;"></i>
                            <strong style="color: #8B4513;">Member Since:</strong> {{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'Not Available' }}
                        </div>
                    </div>
                    <div>
                        <div class="text-center p-3" style="background: linear-gradient(135deg, #F5F5DC, #DDBF94); border-radius: 10px; border: 2px solid #8B4513;">
                            <i class="bx bx-money" style="font-size: 2rem; color: #8B4513;"></i>
                            <div style="color: #8B4513; font-weight: 600;">Total Transactions</div>
                            <div style="font-size: 1.5rem; font-weight: bold; color: #8B4513;">{{ $invoices->count() + $payments->count() }}</div>
                        </div>
                    </div> --}}
                    <div>
                        <div><strong>Bank Name:</strong> {{ $transporter->bank_name ?? 'Not set' }}</div>
                        <div><strong>Email:</strong> {{ Auth::user()->email ?? 'Not Available' }}</div>
                       <div><strong>Account Number:</strong> {{ $account_no }}</div>
                        <div><strong>Account Holder:</strong> {{ $user }}</div>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bx bx-info-circle" style="font-size: 3rem; color: #CD853F;"></i>
                    <p class="mt-2" style="color: #8B4513;">No account details available.</p>
                </div>
            @endif
        </div>
    </div>

    <div>
        @livewire('transporter-transactions')
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    border-radius: 20px;
    transition: all 0.2s;
}

.btn:hover {
    transform: scale(1.05);
}

h2 {
    font-weight: 700;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #8B4513;
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.8em;
    border-radius: 15px;
}
</style>

