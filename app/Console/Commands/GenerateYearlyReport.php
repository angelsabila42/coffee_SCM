<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Delivery;
use App\Models\DeliveryReport;
use App\Helpers\Helper;

class GenerateYearlyReport extends Command
{
    protected $signature = 'report:annual';
    protected $description = 'Generates and stores annual delivery report';

    public function handle()
    {
        Log::info('Annual delivery report generation started at ' . now());

        $startOfYear = now()->subYear()->startOfYear();
        $endOfYear = now()->subYear()->endOfYear();

        $deliveries = Delivery::whereBetween('dispatch_date_time', [$startOfYear, $endOfYear])->get();

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
            'reportID' => Helper::generateID(DeliveryReport::class, 'reportID', 'ADR', 5),
            'start_period' => $startOfYear->toDateString(),
            'end_period' => $endOfYear->toDateString(),
            'title' => 'Annual Delivery Report (' . $startOfYear->year . ')',
            'data' => json_encode($reportData),
            'total_deliveries' => count($deliveries),
        ]);

        Log::info('✅ Annual delivery report saved to database.');
        $this->info('✅ Annual delivery report saved to database.');
    }
}
