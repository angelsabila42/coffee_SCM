<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\IncomingOrder;
use App\Models\CoffeeBatch;
use App\Models\SalesReport;
use App\Helpers\Helper;

class GenerateAnnualSalesReport extends Command
{
    protected $signature = 'generate:annual-sales-report';
    protected $description = 'Generates and stores annual sales data in the sales_reports table';

    public function handle()
    {
        Log::info('Starting annual sales report generation...');

        $startOfYear = now()->subYear()->startOfYear();
        $endOfYear = now()->subYear()->endOfYear();

        $orders = IncomingOrder::whereBetween('created_at', [$startOfYear, $endOfYear])
            ->where('status', 'confirmed')->get();

        $totalSales = 0;
        $totalQuantity = 0;
        $reportData = [];

        foreach ($orders as $order) {
            $batch = CoffeeBatch::where('coffee_type', $order->coffee_type)
                ->where('grade', $order->grade)->first();

            if ($batch) {
                $pricePerKg = $batch->price_per_kilogram;
                $orderTotal = $order->quantity * $pricePerKg;
                $totalSales += $orderTotal;
                $totalQuantity += $order->quantity;

                $reportData[] = [
                    'order_id' => $order->id,
                    'coffee_type' => $order->coffee_type,
                    'grade' => $order->grade,
                    'quantity' => $order->quantity,
                    'price_per_kilogram' => $pricePerKg,
                    'total' => $orderTotal,
                    'ordered_at' => $order->created_at->toDateString(),
                ];
            }
        }

        SalesReport::create([
            'reportID' => Helper::generateID(SalesReport::class, 'reportID', 'AR', 5),
            'start_period' => $startOfYear->toDateString(),
            'end_period' => $endOfYear->toDateString(),
            'title' => 'Annual Sales Report (' . $startOfYear->year . ')',
            'data' => json_encode($reportData),
            'total_sales' => $totalSales,
            'total_quantity' => $totalQuantity,
        ]);

        Log::info('✅ Annual sales report saved.');
        $this->info('✅ Annual sales report saved to database.');
    }
}
