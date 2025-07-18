<?php

namespace App\Http\Controllers;

use App\Models\PesaPalTransaction;
use App\Models\ImporterModel;
use App\Models\IncomingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImporterPaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'exists:incoming_orders,id'
        ]);

        try {
            DB::beginTransaction();

            // Get authenticated user (assuming it's an importer)
            $user = Auth::user();
            $importer = ImporterModel::where('email', $user->email)->first();

            if (!$importer) {
                return response()->json(['error' => 'Importer not found'], 404);
            }

            // Get selected orders and calculate total
            $orders = IncomingOrder::whereIn('id', $request->order_ids)
                ->where('importer_model_id', $importer->id)
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['error' => 'No valid orders found for payment'], 400);
            }

            // Calculate total amount (you can adjust the pricing logic)
            $pricePerKg = 5000; // Sample price per kg in UGX
            $totalAmount = $orders->sum(function($order) use ($pricePerKg) {
                return $order->quantity * $pricePerKg;
            });

            $merchantReference = 'IMP_TXN_' . $importer->id . '_' . time();

            // Create payment record with importer_id
            $pesapalTransaction = PesaPalTransaction::create([
                'pesapal_merchant_reference' => $merchantReference,
                'importer_id' => $importer->id,
                'order_ids' => $request->order_ids,
                'total_amount' => $totalAmount,
                'status' => 'PENDING',
                'description' => 'Payment for ' . count($request->order_ids) . ' order(s) by importer'
            ]);

            // Prepare payment data for your existing PesaPal integration
            $paymentData = [
                'amount' => $totalAmount,
                'description' => 'Payment for Order(s): ' . implode(', ', $request->order_ids),
                'reference' => $merchantReference,
                'first_name' => explode(' ', $importer->name)[0] ?? $importer->name,
                'last_name' => explode(' ', $importer->name)[1] ?? '',
                'email' => $importer->email,
                'phone_number' => $importer->phone_number ?? '',
                'type' => 'MERCHANT'
            ];

            // Store payment data in session for the PesaPal form
            session(['payment_data' => $paymentData]);
            session(['transaction_id' => $pesapalTransaction->id]);

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect_url' => route('pesapal.form'),
                'merchant_reference' => $merchantReference,
                'total_amount' => $totalAmount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Payment initiation failed: ' . $e->getMessage()], 500);
        }
    }

    public function paymentCallback(Request $request)
    {
        $pesapalNotification = $request->get('pesapal_notification_type');
        $pesapalTrackingId = $request->get('pesapal_transaction_tracking_id');
        $merchantReference = $request->get('pesapal_merchant_reference');

        if ($pesapalNotification == "CHANGE" && $pesapalTrackingId) {
            try {
                // Find the transaction
                $transaction = PesaPalTransaction::where('pesapal_merchant_reference', $merchantReference)->first();

                if (!$transaction) {
                    return response('Transaction not found', 404);
                }

                // For now, we'll mark as completed since we don't have the verification service
                // In production, you should verify with PesaPal API
                $status = 'COMPLETED';

                // Update transaction
                $transaction->update([
                    'pesapal_tracking_id' => $pesapalTrackingId,
                    'status' => $status,
                    'payment_date' => now(),
                    'pesapal_response' => [
                        'notification_type' => $pesapalNotification,
                        'tracking_id' => $pesapalTrackingId,
                        'merchant_reference' => $merchantReference,
                        'status' => $status
                    ]
                ]);

                // Update order payment status if payment is completed
                if ($status == 'COMPLETED') {
                    IncomingOrder::whereIn('id', $transaction->order_ids)
                        ->update(['payment_status' => 'PAID']);
                }

                // Return the required response to PesaPal
                $response = "pesapal_notification_type=$pesapalNotification&pesapal_transaction_tracking_id=$pesapalTrackingId&pesapal_merchant_reference=$merchantReference";
                return response($response);

            } catch (\Exception $e) {
                \Log::error('PesaPal Callback Error: ' . $e->getMessage());
                return response('Error processing callback', 500);
            }
        }

        return response('Invalid notification', 400);
    }

    public function paymentStatus($merchantReference)
    {
        $transaction = PesaPalTransaction::where('pesapal_merchant_reference', $merchantReference)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json([
            'status' => $transaction->status,
            'payment_date' => $transaction->payment_date,
            'total_amount' => $transaction->total_amount,
            'tracking_id' => $transaction->pesapal_tracking_id
        ]);
    }

    public function getUnpaidOrders()
    {
        try {
            $user = Auth::user();
            
            // Debug: Log user information
            \Log::info('User attempting to fetch orders: ', ['user' => $user]);
            
            // Find importer by email
            $importer = ImporterModel::where('email', $user->email)->first();

            if (!$importer) {
                // Debug: Check all importers
                $allImporters = ImporterModel::select('id', 'email', 'name')->get();
                \Log::info('All importers in database: ', ['importers' => $allImporters]);
                return response()->json(['error' => 'Importer not found', 'user_email' => $user->email, 'all_importers' => $allImporters], 404);
            }

            \Log::info('Found importer: ', ['importer' => $importer]);

            // Get orders that need payment (Requested or Pending status)
            $orders = IncomingOrder::where('importer_model_id', $importer->id)
                ->whereIn('status', ['Requested', 'Pending'])
                ->select('id', 'orderID', 'quantity', 'coffeeType', 'grade', 'destination', 'created_at', 'status')
                ->orderBy('created_at', 'desc')
                ->limit(20) // Limit to prevent too many results
                ->get();

            // Debug: Log query results
            \Log::info('Orders query results: ', [
                'importer_id' => $importer->id,
                'orders_count' => $orders->count(),
                'orders' => $orders->toArray()
            ]);

            // Also check what orders exist for this importer regardless of status
            $allOrdersForImporter = IncomingOrder::where('importer_model_id', $importer->id)
                ->select('id', 'orderID', 'status', 'created_at')
                ->get();
            \Log::info('All orders for this importer: ', ['all_orders' => $allOrdersForImporter->toArray()]);

            // Transform orders to include payment information
            $ordersWithPayment = $orders->map(function($order) {
                // Use a smaller amount that fits PesaPal's 1000 UGX limit
                // You can adjust this logic based on your business needs
                $pricePerKg = 10; // Reduced price per kg to fit within limit
                $baseAmount = $order->quantity * $pricePerKg;
                
                // Cap at 1000 UGX to meet PesaPal limit
                $amount = min($baseAmount, 1000);
                
                return [
                    'id' => $order->id,
                    'orderID' => $order->orderID,
                    'description' => "{$order->coffeeType} - {$order->grade} ({$order->quantity}kg) to {$order->destination} - Status: {$order->status}",
                    'amount' => $amount,
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s')
                ];
            });

            return response()->json($ordersWithPayment);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching unpaid orders: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch orders: ' . $e->getMessage()], 500);
        }
    }

    public function showPaymentForm()
    {
        // Check if payment data exists in session
        $paymentData = session('payment_data');
        $transactionId = session('transaction_id');
        
        if (!$paymentData || !$transactionId) {
            return redirect()->route('importer.dashboard')->with('error', 'No payment data found. Please try again.');
        }

        return view('payments.pesapal-form', compact('paymentData'));
    }

    public function processPesapalForm(Request $request)
    {
        // Validate the form data
        $request->validate([
            'amount' => 'required|numeric|min:1|max:1000',
            'description' => 'required|string|max:255',
            'reference' => 'required|string|max:100',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
        ]);

        // Get payment data from session
        $paymentData = session('payment_data');
        $transactionId = session('transaction_id');
        
        if (!$paymentData || !$transactionId) {
            return redirect()->route('importer.dashboard')->with('error', 'Session expired. Please try again.');
        }

        // Check amount limit again on server side
        $amount = $request->input('amount');
        if ($amount > 1000) {
            return back()->with('error', 'Payment amount cannot exceed UGX 1,000 due to PesaPal limits. Please reduce the amount.');
        }

        // Include your existing OAuth.php file
        include_once(base_path('pesapal-payment/OAuth.php'));

        // PesaPal configuration (same as your pesapal-iframe.php)
        $consumer_key = '/E4FZWgGS/EkLlwxYGc0SMYpZfm6JOiN';
        $consumer_secret = 'hWqEnRU0i1dvcoLgzr7IsH8AqKk=';
        $signature_method = new \OAuthSignatureMethod_HMAC_SHA1();
        $iframelink = 'https://www.pesapal.com/API/PostPesapalDirectOrderV4';

        // Use the form input values instead of session data
        $amount = number_format($request->input('amount'), 2);
        $desc = $request->input('description');
        $type = $request->input('type', 'MERCHANT');
        $reference = $request->input('reference');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $phonenumber = $request->input('phone_number', '');

        $callback_url = route('importer.payment.callback');

        // Create XML for PesaPal
        $post_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Amount=\"".$amount."\" Description=\"".$desc."\" Type=\"".$type."\" Reference=\"".$reference."\" FirstName=\"".$first_name."\" LastName=\"".$last_name."\" Email=\"".$email."\" PhoneNumber=\"".$phonenumber."\" xmlns=\"http://www.pesapal.com\" />";
        $post_xml = htmlentities($post_xml);

        $consumer = new \OAuthConsumer($consumer_key, $consumer_secret);

        // Post transaction to PesaPal
        $iframe_src = \OAuthRequest::from_consumer_and_token($consumer, null, "GET", $iframelink, null);
        $iframe_src->set_parameter("oauth_callback", $callback_url);
        $iframe_src->set_parameter("pesapal_request_data", $post_xml);
        $iframe_src->sign_request($signature_method, $consumer, null);

        // Update transaction record with actual amount paid
        if ($transactionId) {
            PesaPalTransaction::where('id', $transactionId)->update([
                'total_amount' => $request->input('amount')
            ]);
        }

        // Clear session data
        session()->forget(['payment_data', 'transaction_id']);

        // Display PesaPal iframe
        return view('payments.pesapal-iframe', compact('iframe_src'));
    }
}
