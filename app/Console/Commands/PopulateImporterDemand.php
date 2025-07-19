<?php

namespace App\Console\Commands;

use App\Models\DummyImporterDemand;
use App\Models\ImporterDemand;
use App\Models\IncomingOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PopulateImporterDemand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-importer-demand {--real : Only run with real data}';
    /**Only Schedule Once Real Data Available , Not yet Scheduled**/

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregates importer demand data from incoming orders for a given financial year';

    /**
     * Execute the console command.
     */

    protected function calculateYearsAsCustomer($importerId, $year){
        $firstOrder = IncomingOrder::where('importer_model_id', $importerId)
                    ->orderBy('created_at', 'asc')
                    ->first();

    if(!$firstOrder){
        return 0;
    } 
    $years = $year - $firstOrder->created_at->year;
    return $years < 0 ? 0 : $years;
     }
    public function handle()
    {
        if (! $this->option('real')) {
            $this->warn('This command only runs with --real flag. Skipping.');
        return;
        }
        
        $this->info('Starting Importer Demand Aggregation...');
        $startYear = now()->subYear()->year;
        $startDate =Carbon::create($startYear, 7, 7);
        $endDate = Carbon::create($startYear + 1, 7, 6);

        $importers = \App\Models\ImporterModel::all();

        foreach ($importers as $importer){
            $orders = IncomingOrder::where('importer_model_id', $importer->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();

            if($orders->isEmpty()) continue;

            $robusta = round($orders->where('coffeeType', 'Robusta') ->sum('quantity') / 60);
            $arabica = round($orders->where('coffeeType', 'Arabica')->sum('quantity') / 60);
            $total = $robusta + $arabica;
            $arabicaPct = $total > 0 ? round(($arabica/$total) * 100, 2) : 0;
            $avgOrderSize = round($orders->avg('quantity'), 0);
            $freq = $orders->groupBy(fn ($order) => $order->created_at->month)-> count();

            /**Only Schedule With Real Available Data!, Not on seeded Data!*/
            ImporterDemand::updateOrCreate(
                [
                    'importer_model_id' => $importer->id
                ],
                [
                    'robusta_(60kg_bags)' => $robusta,
                    'arabica_(60kg_bags)' => $arabica,
                    'total_(60kg_bags)' => $total,
                    'arabica_pct' => $arabicaPct,
                    'avgOrderSize' => $avgOrderSize,
                    'orderFreqPerYear' => $freq,
                    'yearsAsCustomer' => $this->calculateYearsAsCustomer($importer->id, $startYear),
                ]
            );
        }
        $this->info('Importer demand aggragation complete');
    }
}
