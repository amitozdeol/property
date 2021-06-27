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
    Route::get('/property', [PropertyController::class, 'index']);
    Route::get('/property/{id}', [PropertyController::class, 'show']);
    Route::post('/property/store', [PropertyController::class, 'store']);
    Route::get('/tenant', [TenantController::class, 'index']);
    Route::post('/tenant/store', [TenantController::class, 'store']);
    Route::post('/rent/{tenant_id}', [RentActivityController::class, 'store']);
});
