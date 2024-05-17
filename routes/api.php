<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\ArendatorsController;
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

Route::group(['middleware' => 'api','prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('cars', [CarsController::class, 'index']);
    Route::get('cars/{id}', [CarsController::class, 'show']);
    Route::post('cars/create', [CarsController::class, 'store']);
    Route::put('cars/{id}/update', [CarsController::class, 'update']);
    Route::delete('cars/{id}/delete', [CarsController::class, 'destroy']);
    Route::get('users', [ArendatorsController::class, 'index']);
    Route::get('users/{id}', [ArendatorsController::class, 'show']);
    Route::post('users/create', [ArendatorsController::class, 'store']);
    Route::put('users/{id}/update', [ArendatorsController::class, 'update']);
    Route::delete('users/{id}/delete', [ArendatorsController::class, 'destroy']);
});

// Route::group(['middleware' => 'api'], function () {
//     Route::get('cars', [CarsController::class, 'index']);
//     Route::get('cars/{id}', [CarsController::class, 'show']);
//     Route::post('cars/create', [CarsController::class, 'store']);
//     Route::put('cars/{id}/update', [CarsController::class, 'update']);
//     Route::delete('cars/{id}/delete', [CarsController::class, 'destroy']);
//     Route::get('users', [ArendatorsController::class, 'index']);
//     Route::get('users/{id}', [ArendatorsController::class, 'show']);
//     Route::post('users/create', [ArendatorsController::class, 'store']);
//     Route::put('users/{id}/update', [ArendatorsController::class, 'update']);
//     Route::delete('users/{id}/delete', [ArendatorsController::class, 'destroy']);
// });