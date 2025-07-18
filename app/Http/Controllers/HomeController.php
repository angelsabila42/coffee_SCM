<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\importerModel;
use App\Models\IncomingOrder;
use App\Models\Payment;
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

    private function calculateOrderKpis(){
         $currentMonth = now()->month;
         $previousMonth = now()->subMonth()->month;

         $currentMonthOrders= IncomingOrder::whereMonth('created_at', $currentMonth)->count();
         $previousMonthOrders= IncomingOrder::whereMonth('created_at', $previousMonth)->count();

         $currentMonthTotalIncome= Payment::whereMonth('created_at', $currentMonth)->sum('amount_paid');
         $previousMonthTotalIncome= Payment::whereMonth('created_at', $previousMonth)->sum('amount_paid');

         $currentMonthPartners= importerModel::whereMonth('created_at', $currentMonth)->count();
         $previousMonthPartners= importerModel::whereMonth('created_at', $previousMonth)->count();

         $currentMonthDeliveries= Delivery::whereMonth('created_at', $currentMonth)->count();
         $previousMonthDeliveries= Delivery::whereMonth('created_at', $previousMonth)->count();

        $percentageChange = 0;

         if($previousMonthOrders > 0){
             $percentageChange = round((($currentMonthOrders - $previousMonthOrders) / $previousMonthOrders) * 100, 1);
        }else{
            $percentageChange = 0;
        } 

         return $percentageChange;
     } 

     public function calculatePartnerKpi(){
         $currentMonth = now()->month;
         $previousMonth = now()->subMonth()->month;

         $currentMonthPartners= importerModel::whereMonth('created_at', $currentMonth)->count();
         $previousMonthPartners= importerModel::whereMonth('created_at', $previousMonth)->count();

        $percentageChange = 0;

         if($previousMonthPartners > 0){
             $percentageChange = round((($currentMonthPartners - $previousMonthPartners) / $previousMonthPartners) * 100, 1);
        }else{
            $percentageChange = 0;
        } 

         return $percentageChange;
     } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        
       $percentageOrderChange = $this->calculateOrderKpis();
       $percentagePartnerKpi = $this->calculatePartnerKpi();

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
            'deliveries' => $deliveries,
            'percentageChange' => $percentageOrderChange,
            'percentagePChange' => $percentagePartnerKpi,
        ]);
    }
}
