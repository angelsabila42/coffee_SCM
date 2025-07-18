<?php

return [
    'consumer_key' => env('PESAPAL_CONSUMER_KEY', '/E4FZWgGS/EkLlwxYGc0SMYpZfm6JOiN'),
    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET', 'hWqEnRU0i1dvcoLgzr7IsH8AqKk='),
    'iframe_url' => env('PESAPAL_IFRAME_URL', 'https://www.pesapal.com/API/PostPesapalDirectOrderV4'),
    'status_url' => env('PESAPAL_STATUS_URL', 'https://www.pesapal.com/api/querypaymentstatus'),
    'callback_url' => env('PESAPAL_CALLBACK_URL', 'http://localhost:8000/importer/payment/callback'),
    'sandbox' => env('PESAPAL_SANDBOX', true), // Set to false for production
];
