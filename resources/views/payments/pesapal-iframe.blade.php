<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PesaPal Payment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
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
            margin: 0;
            padding: 0;
        }
        
        .payment-container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .payment-header {
            background: linear-gradient(135deg, var(--coffee-primary) 0%, var(--coffee-secondary) 100%);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(139, 69, 19, 0.3);
        }
        
        .payment-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="3" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="70" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="70" cy="30" r="2.5" fill="rgba(255,255,255,0.1)"/></svg>');
        }
        
        .payment-header h4 {
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 5px;
        }
        
        .payment-header small {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,0.9);
        }
        
        .iframe-container {
            flex: 1;
            padding: 0;
            margin: 0;
            background: white;
            border-radius: 20px 20px 0 0;
            overflow: hidden;
            box-shadow: 0 -5px 20px rgba(139, 69, 19, 0.1);
        }
        
        iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }
        
        .loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            text-align: center;
        }
        
        .spinner-border {
            width: 4rem;
            height: 4rem;
            border-color: var(--coffee-primary);
            border-right-color: transparent;
        }
        
        .loading-text {
            color: var(--coffee-primary);
            font-weight: 600;
            margin-top: 15px;
        }
        
        .coffee-icon {
            display: inline-block;
            width: 24px;
            height: 24px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M2,21V19H20V21H2M20,8V5L18,5V8C18,10.28 16.54,12.19 14.58,12.81C16.54,13.43 18,15.34 18,17.6V19H4V17.6C4,15.34 5.46,13.43 7.42,12.81C5.46,12.19 4,10.28 4,8V5H2V3H20V5H20M16,8V5H6V8A2,2 0 0,0 8,10H14A2,2 0 0,0 16,8Z"/></svg>') no-repeat center;
            background-size: contain;
            margin-right: 8px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <h4 class="mb-0">
                <span class="coffee-icon"></span>
                Secure Coffee Trade Payment
            </h4>
            <small>Complete your payment safely and securely with PesaPal</small>
        </div>
        
        <div class="iframe-container position-relative">
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading payment...</span>
                </div>
                <div class="loading-text">
                    ☕ Loading secure payment page...
                    <br><small>Brewing your payment experience</small>
                </div>
            </div>
            
            <iframe src="{{ $iframe_src }}" 
                    id="pesapalIframe"
                    scrolling="no" 
                    frameBorder="0"
                    onload="hideLoadingSpinner()">
                <p>Browser unable to load iFrame. Please ensure JavaScript is enabled and try again.</p>
            </iframe>
        </div>
    </div>

    <script>
        function hideLoadingSpinner() {
            const spinner = document.getElementById('loadingSpinner');
            if (spinner) {
                spinner.style.display = 'none';
            }
        }

        // Show loading spinner initially
        document.addEventListener('DOMContentLoaded', function() {
            const iframe = document.getElementById('pesapalIframe');
            const spinner = document.getElementById('loadingSpinner');
            
            // If iframe is already loaded
            if (iframe.contentDocument || iframe.contentWindow.document) {
                hideLoadingSpinner();
            }
            
            // Hide spinner after 10 seconds as fallback
            setTimeout(hideLoadingSpinner, 10000);
        });

        // Listen for messages from PesaPal iframe
        window.addEventListener('message', function(event) {
            // Handle any messages from PesaPal if needed
            console.log('Message from PesaPal:', event.data);
        });

        // Prevent navigation away from payment page
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = 'Are you sure you want to leave? Your payment may not be processed.';
        });
    </script>
</body>
</html>
