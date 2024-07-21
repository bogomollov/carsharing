<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ArendatorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
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

// Route::apiResources(['cars' => CarsController::class,'arendators' => ArendatorsController::class]);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Route::group(['middleware' => 'api','prefix' => 'auth'], function () {
//     Route::post('login', [AuthController::class, 'login']);
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::post('refresh', [AuthController::class, 'refresh']);
//     Route::post('me', [AuthController::class, 'me']);
//     Route::get('users', [ArendatorController::class, 'index']);
//     Route::get('users/{id}', [ArendatorController::class, 'show']);
//     Route::post('users/create', [ArendatorController::class, 'store']);
//     Route::put('users/{id}/update', [ArendatorController::class, 'update']);
//     Route::delete('users/{id}/delete', [ArendatorController::class, 'destroy']);
//     Route::get('cars', [CarController::class, 'index']);
//     Route::get('cars/{id}', [CarController::class, 'show']);
//     Route::post('cars/create', [CarController::class, 'store']);
//     Route::put('cars/{id}/update', [CarController::class, 'update']);
//     Route::delete('cars/{id}/delete', [CarController::class, 'destroy']);
// });

Route::group(['middleware' => 'api'], function () {
    Route::get('user', [ArendatorController::class, 'index']);
    Route::get('user/{id}', [ArendatorController::class, 'show']);
    Route::post('user/create', [ArendatorController::class, 'store']);
    Route::put('user/{id}/update', [ArendatorController::class, 'update']);
    Route::delete('user/{id}/delete', [ArendatorController::class, 'destroy']);
    Route::patch('user/{id}/bill', [ArendatorController::class, 'setDefaultBill']);
    Route::patch('user/{id}/status', [ArendatorController::class, 'setStatus']);

    Route::get('car', [CarController::class, 'index']);
    Route::get('car/{id}', [CarController::class, 'show']);
    Route::post('car/create', [CarController::class, 'store']);
    Route::put('car/{id}/update', [CarController::class, 'update']);
    Route::delete('car/{id}/delete', [CarController::class, 'destroy']);

    Route::get('bill', [BillController::class, 'index']);
    Route::get('bill/{id}', [BillController::class, 'show']);
    Route::post('bill/create', [BillController::class, 'store']);
    Route::put('bill/{id}/update', [BillController::class, 'update']);
    Route::delete('bill/{id}/delete', [BillController::class, 'destroy']);
    Route::patch('bill/{id}', [BillController::class, 'setStatus']);

    Route::get('rent', [RentController::class, 'index']);
    Route::get('rent/{id}', [RentController::class, 'show']);
    Route::post('rent/create', [RentController::class, 'store']);
    Route::put('rent/{id}/update', [RentController::class, 'update']);
    Route::delete('rent/{id}/delete', [RentController::class, 'destroy']);

    Route::get('transaction', [TransactionController::class, 'index']);
    Route::get('transaction/{id}', [TransactionController::class, 'show']);
    Route::post('transaction/create', [TransactionController::class, 'store']);
    Route::put('transaction/{id}/update', [TransactionController::class, 'update']);
    Route::delete('transaction/{id}/delete', [TransactionController::class, 'destroy']);
});