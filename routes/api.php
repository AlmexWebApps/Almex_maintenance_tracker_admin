<?php

use App\Http\Controllers\CatalogItemController;
use App\Http\Controllers\CalibrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user',function(Request $request){
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('items', CatalogItemController::class);

Route::prefix('items/{catalogItem}')->group(function () {
    Route::post('calibrations', [CalibrationController::class, 'store']);
    Route::put('calibrations/{calibration}', [CalibrationController::class, 'update']);
    Route::delete('calibrations/{calibration}', [CalibrationController::class, 'destroy']);
});
