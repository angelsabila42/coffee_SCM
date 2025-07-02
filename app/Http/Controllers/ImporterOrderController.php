<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImporterOrderController extends Controller
{
    public function index(){
        return view('orders.importer-orders');
    }
}
