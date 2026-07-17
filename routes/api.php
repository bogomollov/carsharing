<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ArendatorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CarMarkController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\TransactionController;

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

Route::group(['middleware' => 'api','prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'api'], function () {
    Route::get('arendators', [ArendatorController::class, 'index']);
    Route::get('arendators/{id}', [ArendatorController::class, 'show']);
    Route::post('arendators', [ArendatorController::class, 'store']);
    Route::put('arendators/{id}', [ArendatorController::class, 'update']);
    Route::delete('arendators/{id}', [ArendatorController::class, 'destroy']);
    Route::patch('arendators/{id}/bill', [ArendatorController::class, 'setDefaultBill']);
    Route::patch('arendators/{id}/status', [ArendatorController::class, 'setStatus']);

    Route::get('bills', [BillController::class, 'index']);
    Route::get('bills/{id}', [BillController::class, 'show']);
    Route::post('bills', [BillController::class, 'store']);
    Route::put('bills/{id}', [BillController::class, 'update']);
    Route::delete('bills/{id}', [BillController::class, 'destroy']);
    Route::patch('bills/{id}/status', [BillController::class, 'setStatus']);

    Route::get('cars', [CarController::class, 'index']);
    Route::get('cars/positions', [CarController::class, 'positions']);
    Route::get('cars/{id}', [CarController::class, 'show']);
    Route::post('cars', [CarController::class, 'store']);
    Route::put('cars/{id}', [CarController::class, 'update']);
    Route::delete('cars/{id}', [CarController::class, 'destroy']);
    Route::patch('cars/{id}/status', [CarController::class, 'setStatus']);

    Route::get('car-marks', [CarMarkController::class, 'index']);
    Route::get('car-marks/{id}', [CarMarkController::class, 'show']);
    Route::post('car-marks', [CarMarkController::class, 'store']);
    Route::put('car-marks/{id}', [CarMarkController::class, 'update']);
    Route::delete('car-marks/{id}', [CarMarkController::class, 'destroy']);

    Route::get('car-models', [CarModelController::class, 'index']);
    Route::get('car-models/{id}', [CarModelController::class, 'show']);
    Route::post('car-models', [CarModelController::class, 'store']);
    Route::put('car-models/{id}', [CarModelController::class, 'update']);
    Route::delete('car-models/{id}', [CarModelController::class, 'destroy']);
    Route::patch('car-models/{id}/mark', [CarModelController::class, 'setMark']);
    Route::patch('car-models/{id}/class', [CarModelController::class, 'setClass']);
    Route::patch('car-models/{id}/type', [CarModelController::class, 'setType']);
    Route::patch('car-models/{id}/fuel', [CarModelController::class, 'setFuelType']);
    Route::patch('car-models/{id}/gearbox', [CarModelController::class, 'setGearBox']);
    Route::patch('car-models/{id}/drive', [CarModelController::class, 'setDriveType']);

    Route::get('rents', [RentController::class, 'index']);
    Route::get('rents/{id}', [RentController::class, 'show']);
    Route::post('rents', [RentController::class, 'store']);
    Route::put('rents/{id}', [RentController::class, 'update']);
    Route::delete('rents/{id}', [RentController::class, 'destroy']);
    Route::patch('rents/{id}', [RentController::class, 'closeRent']);

    Route::get('transactions', [TransactionController::class, 'index']);
    Route::get('transactions/{id}', [TransactionController::class, 'show']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::put('transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);
});