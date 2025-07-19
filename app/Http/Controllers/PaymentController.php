<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PesaPalTransaction;
use App\Models\Invoice;
use App\Models\Vendor;
use App\Models\Transporter;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch pesapal transactions with pagination and related importer data
        $payments = PesaPalTransaction::with('importer')
            ->orderByDesc('created_at')
            ->paginate(10);

        // Get the latest invoice for account details
        $latestInvoice = Invoice::orderByDesc('id')->first();

        // Calculate total earnings from pesapal transactions
        $totalEarnings = PesaPalTransaction::where('status', 'COMPLETED')->sum('total_amount');

        $invoices = \App\Models\Invoice::paginate(10); // Fetch invoices for the invoices tab

        return view('payments.index', compact('payments', 'latestInvoice', 'totalEarnings', 'invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate a new unique receipt_number for the form, e.g., PL_XXXX
        $lastPayment = Payment::orderByDesc('id')->first();
        $newReceiptNumber = 'PL_' . str_pad(($lastPayment ? $lastPayment->id : 0) + 1, 4, '0', STR_PAD_LEFT);
        
        $invoices = Invoice::all(); // Fetch all invoices to populate the dropdown

        ActivityLogger::log(
            title: 'Made new Payment',
            type: 'new-payment'
        );

        return view('payments.create', compact('newReceiptNumber', 'invoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receipt_number' => 'required|unique:payments,receipt_number|max:255',
            'invoice_id' => 'nullable|exists:invoices,id',
            'payer' => 'required|string|max:255',
            'amount_paid' => 'required|numeric|min:0',
            'date_paid' => 'required|date',
            'payment_mode' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'coffee_type' => 'nullable|string|max:255',
            'payment_description' => 'nullable|string|max:255',
            'recipient_name' => 'nullable|string|max:255',
            'receipt_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('receipt_file')) {
            $validated['receipt_file_path'] = $request->file('receipt_file')->store('receipts', 'public');
        }

        Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'Payment record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $invoices = Invoice::all(); // Fetch all invoices to populate the dropdown
        return view('payments.edit', compact('payment', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'nullable|exists:invoices,id',
            'payer' => 'required|string|max:255',
            'amount_paid' => 'required|numeric|min:0',
            'date_paid' => 'required|date',
            'payment_mode' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'coffee_type' => 'nullable|string|max:255',
            'payment_description' => 'nullable|string|max:255',
            'recipient_name' => 'nullable|string|max:255',
            'receipt_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($request->hasFile('receipt_file')) {
            // Delete old file if exists
            if ($payment->receipt_file_path) {
                Storage::disk('public')->delete($payment->receipt_file_path);
            }
            $validated['receipt_file_path'] = $request->file('receipt_file')->store('receipts', 'public');
        }

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Payment record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if ($payment->receipt_file_path) {
            Storage::disk('public')->delete($payment->receipt_file_path);
        }
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment record deleted successfully!');
    }

    /**
     * Get pesapal transaction details for modal display
     */
    public function getPesapalTransactionDetails($id)
    {
        try {
            $transaction = PesaPalTransaction::with('importer')->find($id);
            
            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'transaction' => $transaction
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching transaction details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show vendor payment form
     */
    public function showVendorPaymentForm(Request $request)
    {
        // Get vendor data if needed - you may need to adjust this based on your vendor model
        $vendors = Vendor::all(); // Using the correct Vendor model
        
        // Prepare payment data
        $paymentData = [
            'amount' => $request->get('amount', ''),
            'type' => 'VENDOR',
            'description' => 'Vendor Payment for Coffee Supply',
            'reference' => 'VEN-' . date('YmdHis'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@coffeetrade.com',
            'phone_number' => $request->get('phone_number', '')
        ];

        return view('payments.vendor-payment-form', compact('paymentData', 'vendors'));
    }

    /**
     * Show transporter payment form
     */
    public function showTransporterPaymentForm(Request $request)
    {
        // Get transporter data if needed - you may need to adjust this based on your transporter model
        $transporters = Transporter::all(); // Using the correct Transporter model
        
        // Prepare payment data
        $paymentData = [
            'amount' => $request->get('amount', ''),
            'type' => 'TRANSPORTER',
            'description' => 'Transporter Payment for Coffee Delivery',
            'reference' => 'TRA-' . date('YmdHis'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@coffeetrade.com',
            'phone_number' => $request->get('phone_number', ''),
            'delivery_route' => $request->get('delivery_route', '')
        ];

        return view('payments.transporter-payment-form', compact('paymentData', 'transporters'));
    }
}
