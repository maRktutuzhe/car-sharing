<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarMakeController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resources([
    'users' => UserController::class,
    'carmakes' => CarMakeController::class,
    'cars' => CarController::class,
    'prices' => PriceController::class,
]);

Route::prefix('auth')->middleware('api')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('user', 'user');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
