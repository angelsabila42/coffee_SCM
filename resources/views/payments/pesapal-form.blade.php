<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Payment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --coffee-primary: #8B4513;
            --coffee-secondary: #CD853F;
            --coffee-light: #D2B48C;
            --coffee-dark: #5D2A0A;
            --coffee-accent: #F5DEB3;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FAFAFA 0%, #F0E68C 50%, #F5DEB3 100%);
            min-height: 100vh;
        }
        
        .card {
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(139, 69, 19, 0.15);
            border: 2px solid var(--coffee-accent);
            background: white;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--coffee-primary) 0%, var(--coffee-secondary) 100%);
            color: white;
            border-radius: 18px 18px 0 0 !important;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="3" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="70" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="70" cy="30" r="2.5" fill="rgba(255,255,255,0.1)"/></svg>');
        }
        
        .card-header h4 {
            position: relative;
            z-index: 1;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .card-header small {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,0.9);
        }
        
        .form-table {
            width: 100%;
        }
        
        .label-column {
            width: 30%;
            padding: 15px 10px;
            vertical-align: middle;
        }
        
        .label-column label {
            color: var(--coffee-primary);
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .input-column {
            width: 70%;
            padding: 15px 10px;
        }
        
        .button-column {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.02) 0%, rgba(245, 222, 179, 0.3) 100%);
        }
        
        .form-control {
            border: 2px solid #E6E6FA;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
        }
        
        .form-control:focus {
            border-color: var(--coffee-primary);
            box-shadow: 0 0 0 0.3rem rgba(139, 69, 19, 0.15);
            background: white;
        }
        
        .form-control[readonly] {
            background-color: rgba(245, 222, 179, 0.3);
            border-color: var(--coffee-light);
            color: var(--coffee-dark);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--coffee-primary) 0%, var(--coffee-secondary) 100%);
            border: none;
            padding: 15px 45px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(139, 69, 19, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover:before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(139, 69, 19, 0.4);
            background: linear-gradient(135deg, var(--coffee-dark) 0%, var(--coffee-primary) 100%);
        }
        
        .btn-primary:disabled {
            background: #6c757d;
            transform: none;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.2);
        }
        
        .form-text {
            font-size: 0.875rem;
            margin-top: 5px;
        }
        
        .form-text.text-warning {
            color: #FF8C00 !important;
            font-weight: 500;
        }
        
        .form-text.text-danger {
            color: #DC3545 !important;
            font-weight: 600;
        }
        
        .form-text.text-success {
            color: #28A745 !important;
            font-weight: 600;
        }
        
        .is-valid {
            border-color: #28A745 !important;
            box-shadow: 0 0 0 0.3rem rgba(40, 167, 69, 0.15) !important;
        }
        
        .is-invalid {
            border-color: #DC3545 !important;
            box-shadow: 0 0 0 0.3rem rgba(220, 53, 69, 0.15) !important;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        
        .coffee-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M2,21V19H20V21H2M20,8V5L18,5V8C18,10.28 16.54,12.19 14.58,12.81C16.54,13.43 18,15.34 18,17.6V19H4V17.6C4,15.34 5.46,13.43 7.42,12.81C5.46,12.19 4,10.28 4,8V5H2V3H20V5H20M16,8V5H6V8A2,2 0 0,0 8,10H14A2,2 0 0,0 16,8Z"/></svg>') no-repeat center;
            background-size: contain;
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Complete Your Payment</h4>
                    <small>Review your payment details below</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('pesapal.iframe') }}" method="post">
                        @csrf
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <td class="label-column">
                                        <label for="amount" class="form-label">Amount (UGX)</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="number" class="form-control" id="amount" name="amount" 
                                               value="{{ $paymentData['amount'] }}" step="0.01" min="1" max="1000" required>
                                        <div class="form-text text-warning">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            PesaPal has a maximum transaction limit of UGX 1,000. Please adjust your amount.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="type" class="form-label">Type</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="type" name="type" 
                                               value="{{ $paymentData['type'] }}" readonly>
                                        <div class="form-text">Payment type - MERCHANT</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="description" class="form-label">Description</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="description" name="description" 
                                               value="{{ $paymentData['description'] }}" readonly>
                                        <div class="form-text">Payment description</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="reference" class="form-label">Reference</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="reference" name="reference" 
                                               value="{{ $paymentData['reference'] }}" readonly>
                                        <div class="form-text">Transaction reference ID</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="first_name" class="form-label">First Name</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="first_name" name="first_name" 
                                               value="{{ $paymentData['first_name'] }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="last_name" class="form-label">Last Name</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="last_name" name="last_name" 
                                               value="{{ $paymentData['last_name'] }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-column">
                                        <label for="email" class="form-label">Email Address</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="{{ $paymentData['email'] }}" readonly>
                                    </td>
                                </tr>
                                @if($paymentData['phone_number'])
                                <tr>
                                    <td class="label-column">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                    </td>
                                    <td class="input-column">
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" 
                                               value="{{ $paymentData['phone_number'] }}" readonly>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="2" class="button-column">
                                        <button type="submit" class="btn btn-primary">
                                            <span class="coffee-icon"></span>Proceed to Payment
                                        </button>
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-shield-alt me-1" style="color: var(--coffee-secondary);"></i>
                                                Secure payment powered by PesaPal
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                ☕ Supporting coffee trade since 2024
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');

    // Real-time validation
    amountInput.addEventListener('input', function() {
        const amount = parseFloat(this.value);
        const helpText = this.parentNode.querySelector('.form-text');
        
        if (amount > 1000) {
            this.classList.add('is-invalid');
            helpText.className = 'form-text text-danger';
            helpText.innerHTML = '<i class="fas fa-times-circle"></i> Amount exceeds PesaPal limit of UGX 1,000!';
            submitButton.disabled = true;
        } else if (amount < 1) {
            this.classList.add('is-invalid');
            helpText.className = 'form-text text-danger';
            helpText.innerHTML = '<i class="fas fa-times-circle"></i> Amount must be at least UGX 1';
            submitButton.disabled = true;
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
            helpText.className = 'form-text text-success';
            helpText.innerHTML = '<i class="fas fa-check-circle"></i> Amount is valid for PesaPal payment';
            submitButton.disabled = false;
        }
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        const amount = parseFloat(amountInput.value);
        
        if (amount > 1000) {
            e.preventDefault();
            alert('Payment amount cannot exceed UGX 1,000. Please reduce the amount and try again.');
            return false;
        }
        
        if (amount < 1) {
            e.preventDefault();
            alert('Payment amount must be at least UGX 1.');
            return false;
        }
        
        // Show loading state
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span><span class="coffee-icon"></span>Processing Payment...';
        submitButton.disabled = true;
    });

    // Initial validation on page load
    amountInput.dispatchEvent(new Event('input'));
});
</script>
</body>
</html>
