<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;

Route::
post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/register', [UserController::class, 'register']);
    Route::post('/auth/logout', [UserController::class, 'logout']);
});

Route::apiResource('publisher', PublisherController::class);
