<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesReport;

class SaleReport extends Controller
{
    public function show($id)
    {
       $sale = SalesReport::findOrFail($id);
       return view('SalesReportDetails', compact('sale'));
    }
}
