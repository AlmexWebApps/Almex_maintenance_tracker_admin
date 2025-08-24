<?php

use App\Http\Controllers\CatalogItemController;
use App\Http\Controllers\CalibrationController;
use Illuminate\Routing\Route;

Route::apiResource('items', CatalogItemController::class);

Route::prefix('items/{catalogItem}')->group(function () {
    Route::post('calibrations', [CalibrationController::class, 'store']);
    Route::put('calibrations/{calibration}', [CalibrationController::class, 'update']);
    Route::delete('calibrations/{calibration}', [CalibrationController::class, 'destroy']);
});
