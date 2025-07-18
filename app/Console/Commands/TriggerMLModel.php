<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TriggerMLModel extends Command
{
    protected $signature = 'ml:process-data';
    protected $description = 'Trigger all machine learning models sequentially';

    public function handle()
    {
        Log::info('ML model batch trigger started at ' . now());

        // names of the ML scripts to be executed
        $scripts = [
            base_path('python/df_annual_coffee.py'),
            base_path('python/df_coffee_destinations.py'),
            base_path('python/df_coffee_qtn_supplier.py'),
            base_path('python/df_export_qtn_importer.py'),
        ];

        foreach ($scripts as $index => $scriptPath) {
            $scriptName = basename($scriptPath);

            if (!file_exists($scriptPath)) {
                Log::error(" ML script not found: {$scriptPath}");
                $this->error("Script not found: {$scriptPath}");
                continue;
            }

            $output = [];
            $returnVar = 0;

            Log::info(" Running ML script: {$scriptName}");
            exec("\"C:\\Program Files\\Python313\\python.exe\" {$scriptPath}", $output, $returnVar);

            if ($returnVar === 0) {
                Log::info(" ML script {$scriptName} completed successfully at " . now());
                Log::info("Output:\n" . implode("\n", $output));
                $this->info("ML script {$scriptName} ran successfully.");
            } else {
                Log::error(" ML script {$scriptName} failed at " . now());
                Log::error("Error Output:\n" . implode("\n", $output));
                $this->error("ML script {$scriptName} failed.");
            }
        }

        $this->info('All ML scripts have been processed.');
        Log::info('ML model batch trigger ended at ' . now());
    }
}
