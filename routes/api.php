<?php

use App\Http\Controllers\V1\CommissionReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    // commission report routes
    Route::controller(CommissionReportController::class)->group(function () {
        Route::get('commission-reports', 'index');
        Route::get('commision-report/{orderId}', 'getItems');
    });
});