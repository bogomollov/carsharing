<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\UsersController;
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
    Route::get('users', [UsersController::class, 'index']);
    Route::get('users/{id}', [UsersController::class, 'show']);
    Route::post('users/create', [UsersController::class, 'store']);
    Route::put('users/{id}/update', [UsersController::class, 'update']);
    Route::delete('users/{id}/delete', [UsersController::class, 'destroy']);
});