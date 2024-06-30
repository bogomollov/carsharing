<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ArendatorController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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
    Route::get('car', [CarController::class, 'index']);
    Route::get('car/{id}', [CarController::class, 'show']);
    Route::post('car/create', [CarController::class, 'store']);
    Route::put('car/{id}/update', [CarController::class, 'update']);
    Route::delete('car/{id}/delete', [CarController::class, 'destroy']);
});