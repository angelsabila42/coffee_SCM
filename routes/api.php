<?php

use App\Http\Controllers\API\V1\IncomingOrderController;
use App\Http\Controllers\API\V1\OutgoingOrderController;
use App\Http\Controllers\API\V1\VendorController;
use App\Http\Controllers\API\V1\WorkCenterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    Route::get('vendor/dropdown',[VendorController::class, 'dropdown']);
    Route::get('work-center/dropdown',[WorkCenterController::class, 'dropdown']);
    Route::get('outgoing-order/dropdown',[OutgoingOrderController::class, 'dropdown']);
    Route::get('incoming-order/dropdown',[IncomingOrderController::class, 'dropdown']);
    Route::apiResource('incoming-order',IncomingOrderController::class);
    Route::apiResource('outgoing-order',OutgoingOrderController::class);
    Route::apiResource('vendor',VendorController::class);
    Route::apiResource('work-center',WorkCenterController::class);
});