<?php

use App\Http\Controllers\VehicleGeneralSpecsController;
use App\Http\Controllers\VehicleSpecsValuesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/register', function () {
    return redirect('login');
})->name('register');

Route::get('copyCoreSpecs', function () {
    copyCoreSpecs();
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
    Route::controller(VehicleGeneralSpecsController::class)->group(function () {
        Route::get('general-specs', 'index')->name('general_specs');
        Route::get('show/{id}', 'show')->name('show');
    });
    Route::controller(VehicleSpecsValuesController::class)->group(function () {
        Route::get('specs-values', 'index')->name('specs_values');
    });
});
