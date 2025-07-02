<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = DB::table('incoming_orders')
                  ->count();
        $partners = DB::table('importer_models')
                  ->count(); 
        $income = DB::table('payments')
                  ->count();
        $deliveries = DB::table('deliveries')
                  ->count(); 

        return view('Dashboards.home', [
            'order'=> $orders,
            'partners' => $partners,
            'income' => $income,
            'deliveries' => $deliveries
        ]);
    }
}
