<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::prefix('/v1')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'show']);
        Route::put('/user', [AuthController::class, 'update']);
        Route::delete('/user', [AuthController::class, 'destroy']);
        Route::get('/dashboard', [AuthController::class, 'dashboard']);
        Route::apiResource('/clients', ClientController::class);
        Route::patch('/clients/{client}/priority', [ClientController::class, 'updatePriority']);
        Route::post('/clients/{client}/contacts', [ContactController::class, 'store']);
        Route::put('/contacts/{contact}', [ContactController::class, 'update']);
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);
    });
});
