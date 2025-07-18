<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\IncomingOrder;
use App\Models\CoffeeBatch;
use App\Models\SalesReport;
use App\Helpers\Helper;

class GenerateWeeklySalesReport extends Command
{
    protected $signature = 'generate:weekly-sales-report';
    protected $description = 'Generates and stores weekly sales data in the sales_reports table';

    public function handle()
    {
        Log::info('Starting weekly sales report generation...');

        $startOfWeek = now()->subWeek()->startOfWeek();
        $endOfWeek = now()->subWeek()->endOfWeek();

        $orders = IncomingOrder::whereBetween('created_at', [$startOfWeek, $endOfWeek])
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
            'reportID' => Helper::generateID(SalesReport::class, 'reportID', 'SR', 5),
            'start_period' => $startOfWeek->toDateString(),
            'end_period' => $endOfWeek->toDateString(),
            'title' => 'Weekly Sales Report (' . $startOfWeek->format('M d') . ' - ' . $endOfWeek->format('M d') . ')',
            'data' => json_encode($reportData),
            'total_sales' => $totalSales,
            'total_quantity' => $totalQuantity,
        ]);

        Log::info('✅ Weekly sales report saved successfully.');
        $this->info('✅ Weekly sales report saved to database.');
    }
}
