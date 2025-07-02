<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorOrderController extends Controller
{
    public function index(){
        return view('orders.vendor-orders');
    }
}
