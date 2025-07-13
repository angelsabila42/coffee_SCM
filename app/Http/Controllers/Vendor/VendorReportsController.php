<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorReportsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Calculate vendor-specific statistics with fallbacks
        $totalOrders = 0;
        $totalRevenue = 0;
        $totalCoffeeKg = 0;
        $activeClients = 0;
        $recentOrders = collect([]);
        
        try {
            // Get vendor's invoice IDs for payment calculations
            $vendorInvoiceIds = Invoice::where('vendor_id', $user->id)
                                      ->orWhere('vendor_name', $user->name)
                                      ->pluck('id');
            
            // Try to get data from Payment and Invoice models
            $totalRevenue = Payment::whereIn('invoice_id', $vendorInvoiceIds)->sum('amount_paid') ?? 0;
            
            // If Order model exists, use it
            if (class_exists('\App\Models\Order')) {
                $totalOrders = \App\Models\Order::where('vendor_id', $user->id)->count() ?? 0;
                $totalCoffeeKg = \App\Models\Order::where('vendor_id', $user->id)->sum('quantity') ?? 0;
                $activeClients = \App\Models\Order::where('vendor_id', $user->id)
                                     ->distinct('customer_id')
                                     ->count('customer_id') ?? 0;
                                     
                $recentOrders = \App\Models\Order::where('vendor_id', $user->id)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(10)
                                    ->get();
            } else {
                // Use Invoice data as fallback
                $totalOrders = Invoice::where('vendor_id', $user->id)
                                     ->orWhere('vendor_name', $user->name)
                                     ->count() ?? 0;
                                     
                $recentOrders = Invoice::where('vendor_id', $user->id)
                                     ->orWhere('vendor_name', $user->name)
                                     ->orderBy('created_at', 'desc')
                                     ->limit(10)
                                     ->get()
                                     ->map(function($invoice) {
                                         return (object)[
                                             'id' => $invoice->id,
                                             'created_at' => $invoice->created_at,
                                             'client_name' => $invoice->bill_to_name ?? 'N/A',
                                             'coffee_type' => $invoice->coffee_type ?? 'N/A',
                                             'quantity' => $invoice->quantity ?? 0,
                                             'total_amount' => $invoice->total ?? 0,
                                             'status' => $invoice->status ?? 'N/A'
                                         ];
                                     });
            }
        } catch (\Exception $e) {
            // Log error and continue with default values
            \Log::error('Error in VendorReportsController: ' . $e->getMessage());
        }

        return view('vendor.reports', compact(
            'totalOrders',
            'totalRevenue', 
            'totalCoffeeKg',
            'activeClients',
            'recentOrders'
        ));
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        
        // Use Invoice model if Order model doesn't exist
        if (class_exists('\App\Models\Order')) {
            $query = \App\Models\Order::where('vendor_id', $user->id);
        } else {
            $query = Invoice::where('vendor_id', $user->id)->orWhere('vendor_name', $user->name);
        }
        
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->coffee_type) {
            $query->where('coffee_type', $request->coffee_type);
        }
        
        $filteredOrders = $query->get();
        
        return response()->json([
            'success' => true,
            'orders' => $filteredOrders
        ]);
    }

    public function export(Request $request)
    {
        // Implement report export logic here
        return response()->json([
            'success' => true,
            'message' => 'Report export functionality will be implemented'
        ]);
    }
}
