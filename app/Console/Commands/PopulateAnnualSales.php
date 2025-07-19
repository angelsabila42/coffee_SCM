<?php

namespace App\Console\Commands;

use App\Models\AnnualCoffeeSale;
use App\Models\CoffeeBatch;
use App\Models\IncomingOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PopulateAnnualSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-annual-sales {mode=real}';
    /**Only Run On real data! Not Seeded! Not yet scheduled */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate incoming orders to populate the annual_sales table by importer and year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mode = $this->argument('mode');

        if($mode !== 'real'){
            $this->warn('This command only runs in real mode.');
            return;
        }

        $this->info('Populating annual_sales table...');

        $earlieastOrder = IncomingOrder::orderBy('created_at')->first();

        if(!$earlieastOrder){
            $this->warn('No incoming orders found, aborting');
            return;
        }

        $startYear = $earlieastOrder->created_at->year;
        $currentYear = now()->year;

        for($year=$startYear; $year <= $currentYear; $year++){
            $fyStart = Carbon::create($year, 7,7)->startOfDay();
            $fyEnd = Carbon::create($year + 1, 7, 6, 23, 59, 59);

            $orders = IncomingOrder::whereBetween('created_at', [$fyStart, $fyEnd])->get();

            if($orders->isEmpty()){
                continue;
            }
            /**Only Run On real data! Not Seeded! Not yet scheduled */

            $totalQuantityKg = $orders->sum('quantity');
            $bags60kg = round($totalQuantityKg / 60);

            $totalValueUSD = 0;
            $exchangeRateUGXtoUSD = config('coffee.exchange_rate');

            $batches = CoffeeBatch::all()->keyBy(function($batch) {
            return $batch->coffee_type . '-' . $batch->grade;
            });

            foreach($orders as $order){
                $batchKey = $order->coffeeType . '-' . $order->grade;
                $batch = $batches->get($batchKey);

            if($batch){
                $priceUSDPerKg = $batch->price_per_kilogram / $exchangeRateUGXtoUSD;
                $orderValue = $order->quantity * $priceUSDPerKg;
                $totalValueUSD += $orderValue;
            }else{
                $this->warn("No matching coffee batch found for order ID {$order->id} with coffeeType '{$order->coffeeType}' and grade '{$order->grade}'");
            }
            }

            $unitValueUSDPerKg = $totalQuantityKg > 0 ? round($totalValueUSD / $totalQuantityKg, 2) : 0;
             $fyYearString = $year . '/' . substr(($year + 1), 2);
             /**Only Run On real data! Not Seeded! Not yet scheduled */

             AnnualCoffeeSale::updateOrCreate(
                ['year' => $fyYearString],
                [
                    'bags_60kg' => $bags60kg,
                    'metric_tonnes' => round($totalQuantityKg / 1000, 0), // kg to metric tonnes
                    'value_usd' => $totalValueUSD,
                    'unit_value_usd_per_kg' => $unitValueUSDPerKg,
                    'updated_at' => now(),
                ]
            );
            $this->info("Processed financial year: $fyYearString");
        }
        $this->info('Annual coffee sales aggregation complete.'); 
        /**Only Run On real data! Not Seeded! Not yet scheduled */
    }
}
