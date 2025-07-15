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

        // List all 4 script paths (adjust these to your actual locations)
        $scripts = [
            base_path('ml/script1.py'),
            base_path('ml/script2.py'),
            base_path('ml/script3.py'),
            base_path('ml/script4.py'),
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
            exec("python3 {$scriptPath}", $output, $returnVar);

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
