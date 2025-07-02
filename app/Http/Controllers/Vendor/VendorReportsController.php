<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorReportsController extends Controller
{
    public function index(){
        return view('reports.vendor');
    }
}
