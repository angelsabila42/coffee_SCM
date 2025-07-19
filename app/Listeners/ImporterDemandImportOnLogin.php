<?php

namespace App\Listeners;

use App\Services\ImporterDemandImportService;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ImporterDemandImportOnLogin
{
    /**
     * Create the event listener.
     */
   
    protected $importService;
    public function __construct(ImporterDemandImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {

        Log::info("Starting Importer Demand import on login.");

        try {
            $filePath = storage_path('app/private/importer_coffee_quantity.csv');
            $this->importService->importFromCsv($filePath);

            Log::info("Importer Demand import completed");
        } catch (\Exception $e) {
            Log::error("Importer Demand import failed: " . $e->getMessage());
        }
    }
}
