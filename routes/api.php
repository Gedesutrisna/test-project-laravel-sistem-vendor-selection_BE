<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportVendorController;

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

Route::prefix('v1')->group(function () {
    Route::get('user-not-logged-in', function() {
        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    })->name('user-not-logged-in');
    

    Route::middleware('auth:api')->group(function () {
        Route::prefix('report')->group(function () {
            Route::get('/items', [ReportVendorController::class, 'reportItems']);
            Route::get('/ranking', [ReportVendorController::class, 'reportRanking']);
            Route::get('/price-change', [ReportVendorController::class, 'reportPriceChange']);
        });
        Route::apiResource('vendors', VendorController::class);
        Route::apiResource('items', ItemController::class);
        Route::apiResource('vendor-items', VendorItemController::class);
        Route::apiResource('orders', OrderController::class);
    });
});

Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
