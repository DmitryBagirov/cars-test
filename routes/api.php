<?php

use App\Http\Controllers\CarsController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('cars')->group(function () {
        Route::post('release', [CarsController::class, 'release']);
        Route::post('{car}/switch', [CarsController::class, 'switch']);
    });
});

Route::get('cars', [CarsController::class, 'index']);
