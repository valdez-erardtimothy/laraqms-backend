<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CustomerQueueController;
use App\Http\Controllers\Teller\DashboardController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'authenticate']);

// routes for authenticated
Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/get-authenticated', [AuthController::class, 'authenticated']);
        Route::prefix('/teller')->group(function () {
            Route::get('/dashboard', DashboardController::class);
        });
        Route::get('/logout', [AuthController::class, 'logout']);
    });


Route::middleware('unqueued')
    ->post('/enqueue', [CustomerQueueController::class, 'enqueue']);

Route::get(
    '/get-queue-slot',
    [CustomerQueueController::class, 'getQueueNumber']
);
