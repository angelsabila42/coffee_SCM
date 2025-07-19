<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AnnualCoffeeSalesResource;
use Illuminate\Http\Request;
use App\Models\AnnualCoffeeSale;
use App\Services\AnnualCoffeeSaleImportService;

class AnnualCoffeeSaleAdminController extends Controller
{
    public function importCsv(AnnualCoffeeSaleImportService $importService)
{
    $filePath = storage_path('app/private/annual_coffee_sales.csv');
    return $importService->importFromCsv($filePath);
}

    public function exportJSON(){
         return AnnualCoffeeSalesResource::collection(AnnualCoffeeSale::all());
    }
}
