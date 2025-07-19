<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vendor;
use App\Models\OutgoingOrder;
use App\Models\CoffeeBatch;
use App\Models\VendorCluster;

class PopulateVendorCluster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     
    /**Only Run on real data! Not Seeded! Not yet scheduled in Kernel*/
    protected $signature = 'app:populate-vendor-cluster {--real}';
    /**Only Run on real data! Not Seeded! */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate vendor data annually for clustering analysis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! $this->option('real')) {
            $this->warn('Use --real to run this command on production data.');
            return;
        }

        $this->info("Truncating VendorCluster table...");
        VendorCluster::truncate();

        $this->info("Aggregating vendor data...");

        $currentYear = now()->year;
        $totalAllVendors = OutgoingOrder::sum('quantity');
        $vendors = Vendor::all();

        foreach ($vendors as $vendor) {
            $orders = OutgoingOrder::where('vendor_id', $vendor->id)->get();

            if ($orders->isEmpty()) {
                continue;
            }

            $ordersByType = $orders->groupBy('coffeeType');

            $robustaQty = round($ordersByType->get('Robusta', collect())->sum('quantity') / 60);
            $arabicaQty = round($ordersByType->get('Arabica', collect())->sum('quantity') / 60);
            $totalQty = $robustaQty + $arabicaQty;
            $arabicaPct = $totalQty > 0 ? round(($arabicaQty / $totalQty) * 100, 2) : 0;

            $firstOrder = $orders->sortBy('created_at')->first();
            $yearsActive = $firstOrder ? max(0, $currentYear - $firstOrder->created_at->year) : 0;

            $marketSharePct = $totalAllVendors > 0 ? round(($totalQty * 60 / $totalAllVendors) * 100, 3) : 0;

            // Weighted avg price per kg
            $priceSum = 0;
            $qtySum = 0;

            foreach ($ordersByType as $coffeeType => $ordersForType) {
                $batchPrices = CoffeeBatch::where('coffee_type', $coffeeType)->pluck('price_per_kilogram');

                if ($batchPrices->isEmpty()) {
                    continue;
                }

                $avgBatchPrice = $batchPrices->avg();
                $qtyForType = $ordersForType->sum('quantity');

                $priceSum += $avgBatchPrice * $qtyForType;
                $qtySum += $qtyForType;
            }

            $avgPricePerKg = $qtySum > 0 ? round($priceSum / $qtySum, 2) : 0;

            /**Only Run on real data! Not Seeded! */

            VendorCluster::updateOrCreate(
                ['vendor_id' => $vendor->id],
                [
                    'total_(60kg_bags)' => $totalQty,
                    'robusta_(60kg_bags)' => $robustaQty,
                    'arabica_(60kg_bags)' => $arabicaQty,
                    'avgPricePerKg_UGX' => $avgPricePerKg,
                    'yearsActive' => $yearsActive,
                    'marketShare_pct' => $marketSharePct,
                    'arabica_pct' => $arabicaPct,
                ]
            );
        }

        $this->info('Vendor cluster aggregation complete.');
    }
}
