<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\IncomingOrder;
use App\Models\CoffeeBatch;
use App\Models\SalesReport;
use App\Helpers\Helper;

class GenerateMonthlySalesReport extends Command
{
    protected $signature = 'generate:monthly-sales-report';
    protected $description = 'Generates and stores monthly sales data in the sales_reports table';

    public function handle()
    {
        Log::info('Starting monthly sales report generation...');

        $startOfMonth = now()->subMonth()->startOfMonth();
        $endOfMonth = now()->subMonth()->endOfMonth();

        $orders = IncomingOrder::whereBetween('created_at', [$startOfMonth, $endOfMonth])
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
            'reportID' => Helper::generateID(SalesReport::class, 'reportID', 'MR', 5),
            'start_period' => $startOfMonth->toDateString(),
            'end_period' => $endOfMonth->toDateString(),
            'title' => 'Monthly Sales Report (' . $startOfMonth->format('F Y') . ')',
            'data' => json_encode($reportData),
            'total_sales' => $totalSales,
            'total_quantity' => $totalQuantity,
        ]);

        Log::info('✅ Monthly sales report saved.');
        $this->info('✅ Monthly sales report saved to database.');
    }
}
