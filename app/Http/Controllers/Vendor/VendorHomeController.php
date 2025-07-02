<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\OutgoingOrder;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorHomeController extends Controller
{
    public function countOrders(){
        $vendorID = 3; //testing purposes
        $count = OutgoingOrder::where('vendor_id', $vendorID)
                ->where('status','Confirmed')
                ->count();
        return $count;

    }

    public function countDeliveredBatches(){
        $vendorID = 3; //testing purposes
        $count = OutgoingOrder::where('vendor_id', $vendorID)
                ->where('status','Delivered')
                ->count();
        return $count;

    }

    // public function countInvoices(){
    //     $vendorID = 3; //testing purposes
    //     $count = Invoice::where('vendor_id', $vendorID)
    //             ->where('status','Pending')
    //             ->count();
    //     return $count;

    // }

    public function countPendingDeliveries(){
        $vendorID = 3; //testing purposes
        $count = OutgoingOrder::where('vendor_id', $vendorID)
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
