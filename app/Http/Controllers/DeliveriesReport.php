<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryReport;

class DeliveriesReport extends Controller
{
    public function show($id)
    {
       $delivery = DeliveryReport::findOrFail($id);
       return view('DeliveryReportDetails', compact('delivery'));
    }
}
