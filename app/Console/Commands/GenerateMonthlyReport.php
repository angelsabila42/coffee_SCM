<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Delivery;
use App\Models\DeliveryReport;
use App\Helpers\Helper;

class GenerateMonthlyReport extends Command
{
    protected $signature = 'report:monthly';
    protected $description = 'Generates and stores monthly delivery report';

    public function handle()
    {
        Log::info('Monthly delivery report generation started at ' . now());

        $startOfMonth = now()->subMonth()->startOfMonth();
        $endOfMonth = now()->subMonth()->endOfMonth();

        $deliveries = Delivery::whereBetween('dispatch_date_time', [$startOfMonth, $endOfMonth])->get();

        $reportData = [];

        foreach ($deliveries as $delivery) {
            $reportData[] = [
                'delivery_id' => $delivery->delivery_id,
                'pickup_location' => $delivery->pickup_location,
                'dispatch_date_time' => $delivery->dispatch_date_time,
                'destination' => $delivery->delivery_destination,
                'quantity' => $delivery->quantity,
                'coffee_type' => $delivery->coffee_type,
                'coffee_grade' => $delivery->coffee_grade,
                'status' => $delivery->status,
                'driver' => $delivery->assigned_driver,
                'eta' => $delivery->eta,
                'date_ordered' => $delivery->date_ordered,
            ];
        }

        DeliveryReport::create([
            'reportID' => Helper::generateID(DeliveryReport::class, 'reportID', 'DMR', 5),
            'start_period' => $startOfMonth->toDateString(),
            'end_period' => $endOfMonth->toDateString(),
            'title' => 'Monthly Delivery Report (' . $startOfMonth->format('F Y') . ')',
            'data' => json_encode($reportData),
            'total_deliveries' => count($deliveries),
        ]);

        Log::info('✅ Monthly delivery report saved to database.');
        $this->info('✅ Monthly delivery report saved to database.');
    }
}
