<?php

namespace App\Console\Commands;

use App\Models\DummyQuantityDemand;
use App\Models\IncomingOrder;
use App\Models\QuantityDemand;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PopulateQuantityDemand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-quantity-demand {--real : Run on real data only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate incoming orders to populate the quantity_demands table by importer and year';

    /**
     * Execute the console command.
     */

     protected function calculateYearsAsCustomer($importerId, $fyStartYear){
        $firstOrder = IncomingOrder::where('importer_model_id', $importerId)
                    ->orderBy('created_at')
                    ->first();

    if(!$firstOrder){
        return 0;
    } 
    $firstYear = $firstOrder->created_at->year;
    $years = $fyStartYear - $firstYear;
    return max(0, $years);
     }

    public function handle()
    {
        if (! $this->option('real')) {
            $this->warn('This command only runs with --real flag. Skipping.');
        return;
        }
        
        $this->info('Starting Quantity Demand Aggregation...');

        $currentYear = now()->year;
        $importers = \App\Models\ImporterModel::all();

        foreach ($importers as $importer){
            for($year = $currentYear - 5; $year <= $currentYear; $year++){
                $fyStart = Carbon::create($year, 7, 1)->startOfDay();
                $fyEnd = Carbon::create($year + 1, 6, 30, 23, 59, 59);
            
            $orders = IncomingOrder::where('importer_model_id', $importer->id)
                    ->whereBetween('created_at', [$fyStart, $fyEnd])
                    ->get();

            if($orders->isEmpty()) continue;

            $totalQuantityKg = $orders->sum('quantity');
            $bags60kg = (int) round($totalQuantityKg / 60);

            $orderFreqPerYear = $orders->groupBy(fn ($order) => $order->created_at->format('Y-m'))-> count();
            $avgOrderSizeKg = (int) round($orders->avg('quantity'));
            $yearsAsCustomer= $this->calculateYearsAsCustomer($importer->id, $year);

            $fyYearString = $year . '-' . substr($year + 1, 2);

            /**Only Schedule With Real Available Data!, Not on seeded Data!*/
            DummyQuantityDemand::updateOrCreate(
                [
                    'importer_model_id' => $importer->id,
                    'year' => $fyYearString,
                ],
                [
                        'quantity_(60kg_bags)' => $bags60kg,
                        'yearsAsCustomer' => (string) $yearsAsCustomer,
                        'orderFreqPerYear' => $orderFreqPerYear,
                        'avgOrderSize_kg' => $avgOrderSizeKg,
                        'updated_at' => now()
                ]
            );
             $this->info("Processed importer {$importer->id} for FY $fyYearString");
            }
        }
        $this->info('Quantity demands aggregation complete.');
    }
    
}
