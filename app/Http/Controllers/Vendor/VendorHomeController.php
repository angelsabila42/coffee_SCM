<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\OutgoingOrder;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorHomeController extends Controller
{
    public $vendor;
     public function __construct()
    {
        // Use the logged-in user's email to find the corresponding vendor
        $this->middleware(function ($request, $next) {
            $email = Auth::user()->email;

            $this->vendor = Vendor::where('email', $email)->first();

            if (!$this->vendor) {
                abort(403, 'Unauthorized - No vendor account associated with your email.');
            }

            return $next($request);
        });
    }
    
    public function countOrders(){
        $count = OutgoingOrder::where('vendor_id', $this->vendor->id)
                ->where('status','Confirmed')
                ->count();
        return $count;

    }

    public function countDeliveredBatches(){
       
        $count = OutgoingOrder::where('vendor_id', $this->vendor->id)
                ->where('status','Delivered')
                ->count();
        return $count;

    }

    // public function countInvoices(){
    //     $vendorID = 3; //testing purposes
    //     $count = Invoice::where('vendor_id', $this->vendor->id)
    //             ->where('status','Pending')
    //             ->count();
    //     return $count;

    // }

    public function countPendingDeliveries(){
       
        $count = OutgoingOrder::where('vendor_id', $this->vendor->id)
                ->where('status','Pending')
                ->count();
        return $count;

    }
    public function index(){     
        return view('Dashboards.vendor-home',[
            'orders' => $this->countOrders(),
            'delivered' => $this->countDeliveredBatches(),
            'pending' => $this->countPendingDeliveries(),
            // 'invoices' => $this->countInvoices(),

        ]);

    }
}
