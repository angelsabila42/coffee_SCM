<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\IncomingOrder;
use App\Models\CoffeeBatch;

class GenerateWeeklySalesRport extends Command
{
    protected $signature = 'generate:weekly-sales-rport';
    protected $description = 'Generates weekly sales report';

    public function handle()
    {
        Log::info('Weekly sales report generation started at ' . now());

        $startOfWeek = now()->subWeek()->startOfWeek();
        $endOfWeek = now()->subWeek()->endOfWeek();

        $orders = IncomingOrder::whereBetween('created_at', [$startOfWeek, $endOfWeek])
             ->where('status', 'confirmed')->get();
             $totalSales = 0;
             $totalQuantity = 0;

             foreach($orders as $order){
                $batch = CoffeeBatch::where('coffee_type', $order->coffee_type)
                ->where('grade', $order->grade)->first();
                
                if($batch){
                    $pricePerKg = $batch->price_per_kg;
                    $orderTotal = $order->quantity * $pricePerKg;
                    $totalSales += $orderTotal;
                    $totalQuantity += $order->quantity;
                }
             }
         $pdf = app('dompdf.wrapper')->loadView('livewire.sales-report-table', []);

        $filename = 'reports/weekly_report_' . now()->format('Y_m_d_H-i-s') . '.pdf';
        Storage::put($filename, $pdf->output());

        Log::info('Weekly sales report generated at ' . $filename);
        $this->info('Weekly sales report generated successfully.');
    }
}
