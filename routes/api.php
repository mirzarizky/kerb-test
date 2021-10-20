<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use Illuminate\Http\Request;
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

Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('login', LoginController::class)->middleware('throttle:6,1');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', LogoutController::class);
    });
});
