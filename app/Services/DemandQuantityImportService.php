<?php

namespace App\Services;

use App\Models\ImporterModel;
use App\Models\QuantityDemand;
use Illuminate\Support\Facades\Log;

class DemandQuantityImportService
{
    public function importFromCsv(string $filePath): array
    {
        if (!file_exists($filePath)) {
            return [
                'error' => "CSV file not found at {$filePath}"
            ];
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
                Log::warning('Importer name missing in csv row: ' . json_encode($data));
                continue;
            }

            $importer = ImporterModel::whereRaw('LOWER(name) = ?', [strtolower($importerName)])->first();

            if (!$importer) {
                Log::warning("Importer not found for name: '{$importerName}'");
                $skippedImporters[] = $importerName;
                continue;
            }

            QuantityDemand::updateOrCreate([
                'importer_model_id' => $importer->id,
                'year' => $data['year'] ?? 0,
            ], [
                'quantity_(60kg_bags)' => $data['quantity_(60kg_bags)'] ?? 0,
                'yearsAsCustomer' => $data['yearsAsCustomer'] ?? 0,
                'orderFreqPerYear' => $data['orderFreqPerYear'] ?? 0,
                'avgOrderSize_kg' => $data['avgOrderSize_kg'] ?? 0,
            ]);

            $importedCount++;
        }

        $response = [
            'message' => "Import completed successfully. Records imported: {$importedCount}.",
        ];

        if (!empty($skippedImporters)) {
            $response['skipped_importers'] = array_unique($skippedImporters);
            $response['warning'] = 'Some importer names in CSV were not found and were skipped.';
        }

        return $response;
    }
}
