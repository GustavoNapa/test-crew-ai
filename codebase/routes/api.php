<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    Route::middleware('auth:sanctum')->get('/', function() {
        return [
            'message' => 'success'
        ];
    });
    Route::prefix('/gateway')->group(function () {
        Route::middleware('auth:sanctum')->post('/dynamic-qrcode', [App\Http\Controllers\Api\Gateway\DynamicQrCodeController::class, 'create']);
        Route::middleware('auth:sanctum')->get('/dynamic-qrcode', [App\Http\Controllers\Api\Gateway\DynamicQrCodeController::class, 'view']);
        Route::middleware('auth:sanctum')->get('/dynamic-qrcode/{id}', [App\Http\Controllers\Api\Gateway\DynamicQrCodeController::class, 'getPayment']);

        Route::middleware('auth:sanctum')->post('/withdraw/pix', [App\Http\Controllers\Api\Gateway\Withdraw\PixController::class, 'create']);
        Route::middleware('auth:sanctum')->get('/withdraw/pix/{id}', [App\Http\Controllers\Api\Gateway\Withdraw\PixController::class, 'getPayment']);
        
        Route::middleware('auth:sanctum')->post('/pix-payment', [App\Http\Controllers\Api\Gateway\Withdraw\PixController::class, 'pixPayment']);
    });

    Route::prefix('/webhook')->group(function () {
        Route::post('/transactions', [App\Http\Controllers\Api\Gateway\DynamicQrCodeController::class, 'webhook']);
        Route::post('/withdraw/pix', [App\Http\Controllers\Api\Gateway\Withdraw\PixController::class, 'webhook']);
    });
});