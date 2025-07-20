<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class VendorTransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get vendor-specific invoices
        $invoices = Invoice::where('vendor_id', $user->id)
                          ->orWhere('vendor_name', $user->name)
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        
        // Get vendor's invoice IDs
        $vendorInvoiceIds = Invoice::where('vendor_id', $user->id)
                                  ->orWhere('vendor_name', $user->name)
                                  ->pluck('id');
        
        // Get payments related to vendor's invoices with invoice data
        $payments = Payment::with('invoice')
                          ->whereIn('invoice_id', $vendorInvoiceIds)
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        
        // Get the latest invoice for account details
        $latestInvoice = Invoice::where('vendor_id', $user->id)
                                ->orWhere('vendor_name', $user->name)
                                ->orderByDesc('id')
                                ->first();

        // Calculate statistics based on vendor's invoices and payments
        $totalEarnings = Payment::whereIn('invoice_id', $vendorInvoiceIds)->sum('amount_paid') ?? 0;
        $paidInvoices = Invoice::where('vendor_id', $user->id)
                               ->orWhere('vendor_name', $user->name)
                               ->where('status', 'Paid')
                               ->count();
        $pendingInvoices = Invoice::where('vendor_id', $user->id)
                                  ->orWhere('vendor_name', $user->name)
                                  ->where('status', 'Awaiting')
                                  ->count();
        $totalPayments = Payment::whereIn('invoice_id', $vendorInvoiceIds)->count();
        
        // Get last payment
        $lastPayment = Payment::whereIn('invoice_id', $vendorInvoiceIds)
                              ->orderByDesc('created_at')
                              ->first();
   
        return view('vendor.transactions', compact(
            'payments', 
            'invoices', 
            'latestInvoice', 
            'totalEarnings',
            'paidInvoices',
            'pendingInvoices', 
            'totalPayments',
            'lastPayment'
        ));
    }
}
