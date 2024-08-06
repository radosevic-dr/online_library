<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PublisherController;

Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/register', [UserController::class, 'register']);
    Route::post('/auth/logout', [UserController::class, 'logout']);

    // Publisher routes

    Route::post('/auth/publishers/create', [PublisherController::class, 'createPublisher']);
});
