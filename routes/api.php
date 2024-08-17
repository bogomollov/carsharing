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
    Route::get('arendator', [ArendatorController::class, 'index']);
    Route::get('arendator/{id}', [ArendatorController::class, 'show']);
    Route::post('arendator', [ArendatorController::class, 'store']);
    Route::put('arendator/{id}', [ArendatorController::class, 'update']);
    Route::delete('arendator/{id}', [ArendatorController::class, 'destroy']);
    Route::patch('arendator/{id}/bill', [ArendatorController::class, 'setDefaultBill']);
    Route::patch('arendator/{id}/status', [ArendatorController::class, 'setStatus']);

    Route::get('bill', [BillController::class, 'index']);
    Route::get('bill/{id}', [BillController::class, 'show']);
    Route::post('bill', [BillController::class, 'store']);
    Route::put('bill/{id}', [BillController::class, 'update']);
    Route::delete('bill/{id}', [BillController::class, 'destroy']);
    Route::patch('bill/{id}/status', [BillController::class, 'setStatus']);

    Route::get('car', [CarController::class, 'index']);
    Route::get('car/{id}', [CarController::class, 'show']);
    Route::post('car', [CarController::class, 'store']);
    Route::put('car/{id}', [CarController::class, 'update']);
    Route::delete('car/{id}', [CarController::class, 'destroy']);
    Route::patch('car/{id}/status', [CarController::class, 'setStatus']);

    Route::get('car_mark', [CarMarkController::class, 'index']);
    Route::get('car_mark/{id}', [CarMarkController::class, 'show']);
    Route::post('car_mark', [CarMarkController::class, 'store']);
    Route::put('car_mark/{id}', [CarMarkController::class, 'update']);
    Route::delete('car_mark/{id}', [CarMarkController::class, 'destroy']);

    Route::get('car_model', [CarModelController::class, 'index']);
    Route::get('car_model/{id}', [CarModelController::class, 'show']);
    Route::post('car_model', [CarModelController::class, 'store']);
    Route::put('car_model/{id}', [CarModelController::class, 'update']);
    Route::delete('car_model/{id}', [CarModelController::class, 'destroy']);
    Route::patch('car_model/{id}/mark', [CarModelController::class, 'setMark']);
    Route::patch('car_model/{id}/class', [CarModelController::class, 'setClass']);
    Route::patch('car_model/{id}/type', [CarModelController::class, 'setType']);
    Route::patch('car_model/{id}/fuel', [CarModelController::class, 'setFuelType']);
    Route::patch('car_model/{id}/gearbox', [CarModelController::class, 'setGearBox']);
    Route::patch('car_model/{id}/drive', [CarModelController::class, 'setDriveType']);

    Route::get('rent', [RentController::class, 'index']);
    Route::get('rent/{id}', [RentController::class, 'show']);
    Route::post('rent', [RentController::class, 'store']);
    Route::put('rent/{id}', [RentController::class, 'update']);
    Route::delete('rent/{id}', [RentController::class, 'destroy']);
    Route::patch('rent/{id}', [RentController::class, 'closeRent']);

    Route::get('transaction', [TransactionController::class, 'index']);
    Route::get('transaction/{id}', [TransactionController::class, 'show']);
    Route::post('transaction', [TransactionController::class, 'store']);
    Route::put('transaction/{id}', [TransactionController::class, 'update']);
    Route::delete('transaction/{id}', [TransactionController::class, 'destroy']);
});