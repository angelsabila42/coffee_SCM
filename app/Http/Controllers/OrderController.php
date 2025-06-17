<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $invoices = Invoice::paginate(10);
        $payments = Payment::paginate(10);
        return view('orders.index', compact('invoices', 'payments'));
    }
} 