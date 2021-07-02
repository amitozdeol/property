<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RentActivityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::prefix('property')->group(function () {
        Route::get('/exist', [PropertyController::class, 'isExist']);
        Route::get('/', [PropertyController::class, 'index']);
        Route::get('/{id}', [PropertyController::class, 'show']);
        Route::post('/store', [PropertyController::class, 'store']);
    });
    Route::prefix('tenant')->group(function () {
        Route::get('/', [TenantController::class, 'index']);
        Route::post('/store', [TenantController::class, 'store']);
        Route::get('/rent/pending', [TenantController::class, 'rentPending']);
    });
    Route::prefix('rent')->group(function () {
        Route::get('/latest', [RentActivityController::class, 'latest']);
        Route::post('/{tenant_id}', [RentActivityController::class, 'store']);
    });
});
