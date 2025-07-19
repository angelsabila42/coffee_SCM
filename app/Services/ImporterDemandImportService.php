<?php

namespace App\Services;

use App\Models\ImporterDemand;
use App\Models\ImporterModel;
use Illuminate\Support\Facades\Log;

class ImporterDemandImportService
{
    public function importFromCsv(string $filePath): array
    {
        if (!file_exists($filePath)) {
            Log::error("CSV file not found at {$filePath}");
            return ['error' => "CSV file not found at {$filePath}"];
        }

        $csv = array_map('str_getcsv', file($filePath));
        $headers = array_map(function ($header) {
            return trim(preg_replace('/[\x{FEFF}]/u', '', $header));
        }, $csv[0]);
        unset($csv[0]);

        $importedCount = 0;
        $skippedImporters = [];

        foreach ($csv as $row) {
            $data = array_combine($headers, $row);

            $importerName = trim($data['importer'] ?? '');
            if (!$importerName) {
                Log::warning('Importer name missing in CSV row: ' . json_encode($data));
                continue;
            }

            $importer = ImporterModel::whereRaw('LOWER(name) = ?', [strtolower($importerName)])->first();

            if (!$importer) {
                Log::warning("Importer not found for name: '{$importerName}'");
                $skippedImporters[] = $importerName;
                continue;
            }

            ImporterDemand::updateOrCreate(
                ['importer_model_id' => $importer->id],
                [
                    'robusta_(60kg_bags)' => (int) ($data['robusta_(60kg_bags)'] ?? 0),
                    'arabica_(60kg_bags)' => (int) ($data['arabica_(60kg_bags)'] ?? 0),
                    'yearsAsCustomer' => (int) ($data['yearsAsCustomer'] ?? 0),
                    'orderFreqPerYear' => (int) ($data['orderFreqPerYear'] ?? 0),
                    'total_(60kg_bags)' => (int) ($data['total_(60kg_bags)'] ?? 0),
                    'arabica_pct' => (float) ($data['arabica_pct'] ?? 0),
                    'avgOrderSize' => (int) ($data['avgOrderSize'] ?? 0),
                ]
            );

            $importedCount++;
        }

        return [
            'imported' => $importedCount,
            'skipped' => array_unique($skippedImporters),
        ];
    }
}
