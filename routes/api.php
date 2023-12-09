<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InteractionController;
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


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/login','login');
    Route::post('/signup','signup');

});
Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::resource('interactions', InteractionController::class);
    Route::post('interactions/{interaction}/events', [InteractionController::class, 'simulateEvent']);
    Route::get('/interactions/{interaction}/statistics', [InteractionController::class, 'getStatistics']);
});
