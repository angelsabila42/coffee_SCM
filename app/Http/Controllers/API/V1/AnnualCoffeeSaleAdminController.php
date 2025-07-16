<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AnnualCoffeeSalesResource;
use Illuminate\Http\Request;
use App\Models\AnnualCoffeeSale;
class AnnualCoffeeSaleAdminController extends Controller
{
    public function importCsv(){
        $filePath = storage_path('app/private/annual_coffee_sales.csv');

        if(!file_exists($filePath)){
            return "CSV file not found at {$filePath}";
        }

        $csv = array_map('str_getcsv', file($filePath));
        $headers = array_map(function ($header){
            return trim(preg_replace('/[\x{FEFF}]/u', '', $header));
        },$csv[0]);
        unset($csv[0]);

        foreach ($csv as $row){
            $data = array_combine($headers, $row);

            if(!empty($data['year'])){
                try {
                    AnnualCoffeeSale::updateOrCreate([
                   'year' => $data['year'],
                    'bags_60kg' => $data['bags_60kg'],
                    'metric_tonnes' => $data['metric_tonnes'],
                    'value_usd' => $data['value_usd'],
                    'unit_value_usd_per_kg' => $data['unit_value_usd_per_kg'],
                ]);
                }catch(\Exception $e){
                    dd('Insert failed', $data, $e->getMessage());
                }
                
            }
        }
        return "Import completed Successfully";
    }

    public function exportJSON(){
         return AnnualCoffeeSalesResource::collection(AnnualCoffeeSale::all());
    }
}
