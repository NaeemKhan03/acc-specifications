<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleGeneralSpecsController;
use App\Http\Controllers\VehicleSpecsValuesController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/dealer')->group(function () {
    Route::controller(VehicleGeneralSpecsController::class)->group(function () {
        Route::post('scrapped-specs', 'scrappedSpecsValues');
        Route::post('store-general-specs/{id}', 'storeVehicleGeneralSpecs');
        Route::post('/delete-vehicle-specs', 'deleteVehicleGeneralSpecs');
    });
});
Route::controller(VehicleGeneralSpecsController::class)->group(function () {
    Route::get('/show-specs/{slug}', 'showGeneralSpecs');
});
Route::controller(VehicleSpecsValuesController::class)->group(function () {
    Route::POST('specs-suggestion', 'specsSuggestion')->name('specs.suggestion');
});
