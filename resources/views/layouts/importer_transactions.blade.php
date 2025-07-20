<div class="">
    <h2 class="mb-4">Transactions</h2>
    <div class="card mb-4 rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
             <div class="card-header">Account Details</div>
             </div>
       
        <div class="card-body">
            @if(isset($account_no) && isset($account_holder))
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div><strong>Account Number:</strong> {{ $account_no }}</div>
                        <div><strong>Account Holder:</strong> {{ $account_holder }}</div>
                        @if(isset($bank_name))
                        <div><strong>Bank Name:</strong> {{ $bank_name }}</div>
                        @endif
                        @if(isset($importer))
                        <div><strong>Account Name:</strong> {{ $importer->name }}</div>
                        <div><strong>Email:</strong> {{ $importer->email }}</div>
                        @endif
                    </div>
                    <div data-bs-toggle="dropdown" aria-expanded="false" class="dropdown">
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Bank Transfer</a></li>
                            <li><a class="dropdown-item" href="#">Mobile Money</a></li>
                            <li><a class="dropdown-item" href="#">Cash</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Payment Section within Account Details -->
                <div class="mt-4 pt-3 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Select Orders to Pay:</h6>
                            <div id="orders-list" class="mb-3" style="max-height: 300px; overflow-y: auto;">
                                <!-- Orders will be loaded here via AJAX -->
                                <div class="text-center">
                                    <div class="spinner-border text-primary spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading orders...</span>
                                    </div>
                                    <small class="d-block text-muted mt-2">Loading orders...</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="payment-summary p-3" style="background-color: #f8f9fa; border-radius: 8px; display: none;">
                                <h6 class="text-primary mb-2">Payment Summary</h6>
                                <div class="mb-2">
                                    <small><strong>Selected Orders:</strong> <span id="selected-count">0</span></small>
                                </div>
                                <div class="mb-3">
                                    <strong class="text-success">Total: UGX <span id="total-amount">0</span></strong>
                                </div>
                                <button type="button" id="proceed-payment" class="btn btn-success w-100" disabled>
                                    <i class="fas fa-credit-card"></i> Proceed to Payment
                                </button>
                            </div>
                            <div id="no-selection-message" class="text-center text-muted">
                                <i class="fas fa-info-circle" style="font-size: 2rem;"></i>
                                <p class="mt-2">Select orders to see payment summary</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div>No account details available.</div>
            @endif
        </div>
    </div> 

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">
                        <i class="fas fa-credit-card"></i> Complete Payment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="payment-iframe-container">
                        <!-- PesaPal iframe will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div>        
            <livewire:importer-transactions />


        </div>
</div>

<!-- Payment JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadUnpaidOrders();
    
    const proceedButton = document.getElementById('proceed-payment');
    if (proceedButton) {
        proceedButton.addEventListener('click', initiatePayment);
    }
});

function loadUnpaidOrders() {
    fetch('/importer/payment/unpaid-orders', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        displayOrders(data);
    })
    .catch(error => {
        console.error('Error loading orders:', error);
        const ordersList = document.getElementById('orders-list');
        if (ordersList) {
            ordersList.innerHTML = '<div class="alert alert-danger">Error loading orders. Please refresh the page.</div>';
        }
    });
}

function displayOrders(orders) {
    const container = document.getElementById('orders-list');
    if (!container) return;
    
    if (orders.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No unpaid orders found.</div>';
        return;
    }
    
    let html = '';
    orders.forEach(order => {
        html += `
            <div class="form-check mb-2 p-2 border rounded">
                <input class="form-check-input order-checkbox" 
                       type="checkbox" 
                       value="${order.id}" 
                       data-amount="${order.amount}"
                       id="order-${order.id}">
                <label class="form-check-label w-100" for="order-${order.id}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Order #${order.id}</strong>
                            <br><small class="text-muted">${new Date(order.created_at).toLocaleDateString()}</small>
                        </div>
                        <div class="text-end">
                            <span class="text-success"><strong>UGX ${parseFloat(order.amount).toLocaleString()}</strong></span>
                        </div>
                    </div>
                </label>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // Add event listeners to checkboxes
    document.querySelectorAll('.order-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotal);
    });
}

function calculateTotal() {
    let total = 0;
    let selectedCount = 0;
    
    document.querySelectorAll('.order-checkbox:checked').forEach(checkbox => {
        total += parseFloat(checkbox.dataset.amount);
        selectedCount++;
    });
    
    const totalAmountEl = document.getElementById('total-amount');
    const selectedCountEl = document.getElementById('selected-count');
    const proceedButton = document.getElementById('proceed-payment');
    
    if (totalAmountEl) totalAmountEl.textContent = total.toLocaleString();
    if (selectedCountEl) selectedCountEl.textContent = selectedCount;
    if (proceedButton) proceedButton.disabled = selectedCount === 0;
    
    // Show/hide payment summary and no selection message
    const summary = document.querySelector('.payment-summary');
    const noSelectionMessage = document.getElementById('no-selection-message');
    
    if (selectedCount > 0) {
        if (summary) summary.style.display = 'block';
        if (noSelectionMessage) noSelectionMessage.style.display = 'none';
    } else {
        if (summary) summary.style.display = 'none';
        if (noSelectionMessage) noSelectionMessage.style.display = 'block';
    }
}

function initiatePayment() {
    const selectedOrders = Array.from(document.querySelectorAll('.order-checkbox:checked'))
                               .map(cb => cb.value);
    
    if (selectedOrders.length === 0) {
        alert('Please select at least one order to pay for.');
        return;
    }
    
    // Show loading state
    const button = document.getElementById('proceed-payment');
    if (!button) return;
    
    const originalText = button.innerHTML;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    button.disabled = true;
    
    fetch('/importer/payment/initiate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            order_ids: selectedOrders
        })
    })
    .then(response => response.json())
    .then(data => {
        button.innerHTML = originalText;
        button.disabled = false;
        
        if (data.success) {
            // Redirect to payment form instead of showing iframe
            window.location.href = data.redirect_url;
            
        } else {
            alert('Payment initiation failed: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        button.innerHTML = originalText;
        button.disabled = false;
        console.error('Error:', error);
        alert('An error occurred while initiating payment. Please try again.');
    });
}

// Check payment status periodically when modal is open
let statusCheckInterval;
const paymentModal = document.getElementById('paymentModal');
if (paymentModal) {
    paymentModal.addEventListener('shown.bs.modal', function() {
        if (window.currentMerchantReference) {
            statusCheckInterval = setInterval(checkPaymentStatus, 5000); // Check every 5 seconds
        }
    });

    paymentModal.addEventListener('hidden.bs.modal', function() {
        if (statusCheckInterval) {
            clearInterval(statusCheckInterval);
        }
    });
}

function checkPaymentStatus() {
    if (!window.currentMerchantReference) return;
    
    fetch(`/importer/payment/status/${window.currentMerchantReference}`)
    .then(response => response.json())
    .then(data => {
        if (data.status === 'COMPLETED') {
            clearInterval(statusCheckInterval);
            alert('Payment completed successfully!');
            // Close modal and reload page
            const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
            if (modal) modal.hide();
            window.location.reload();
        } else if (data.status === 'FAILED') {
            clearInterval(statusCheckInterval);
            alert('Payment failed. Please try again.');
            const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
            if (modal) modal.hide();
        }
    })
    .catch(error => {
        console.error('Status check error:', error);
    });
}
</script>
      