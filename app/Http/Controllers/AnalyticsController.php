<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $deliveryStatusData = collect([
            ['status' => 'Pending', 'total' => 15],
            ['status' => 'Completed', 'total' => 45],
             ]);

                // $deliveryStatusData = DB::table('deliveries')
                //             ->select('status', DB::raw('COUNT(*) as total'))
                //             ->whereIn('status', ['Pending', 'Completed'])
                //             ->groupBy('status')
                //             ->get();
                            // dd(DB::table('deliveries')->count());
        return view('analytics',compact('deliveryStatusData'));
    }
}
