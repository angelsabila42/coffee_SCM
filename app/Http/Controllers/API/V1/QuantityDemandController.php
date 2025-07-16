<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\QuantityDemandResource;
use App\Models\ImporterModel;
use App\Models\QuantitiyDemand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuantityDemandController extends Controller
{
        public function importCsv(){
        $filePath = storage_path('app/private/demand_qtn.csv');
        

        if(!file_exists($filePath)){
            return "CSV file not found at {$filePath}";
        }

        $csv = array_map('str_getcsv', file($filePath));

        $headers = array_map(function ($header){
        return trim(preg_replace('/[\x{FEFF}]/u', '', $header));
        },$csv[0]);
        unset($csv[0]);

        $importedCount = 0;
        $skippedImporters =[];

        foreach ($csv as $row){
            $data = array_combine($headers, $row);

            $importerName = trim($data['importer'] ?? '');
            if(!$importerName){
                Log::warning('Importer name missing in csv row: ' . json_encode($data));
                continue;
            }

            $importer = ImporterModel::whereRaw('LOWER(name) = ?',[strtolower($importerName)])->first();
            if (!$importer){
                Log::warning("Importer not found for name: '{$importerName}' ");
                $skippedImporters[] = $importerName;
                continue;
            }

            Log::info("Parsed keys:", array_keys($data));


            QuantitiyDemand::updateOrCreate([
                'importer_model_id'=> $importer->id,
                'year'=>$data['year'] ?? 0,
                'quantity_(60kg_bags)' => $data['quantity_(60kg_bags)'] ?? 0,
                'yearsAsCustomer' => $data['yearsAsCustomer'] ?? 0,
                'orderFreqPerYear' => $data['orderFreqPerYear'] ?? 0,
                'avgOrderSize_kg' => $data['avgOrderSize_kg'] ?? 0,
                
            ]);

            $importedCount++;
        }

        $response = [
            'message' => "Import completed Successfully. Records imported: {$importedCount}. ",
        ];

        if(!empty($skippedImporters)){
            $uniqueSkipped = array_unique($skippedImporters);
            $response['skipped_importers'] = $uniqueSkipped;
            $response['warning'] = 'Some importer names in csv were not found in the importers table and were skipped';
        }
        return response()->json($response);
    }

    public function exportJSON(){
        $demand = QuantitiyDemand::with('importerModel')->get();
        return QuantityDemandResource::collection($demand);
    }
}
