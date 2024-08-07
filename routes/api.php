<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;


Route::post('/auth/login', [UserController::class, 'login']);
Route::apiResource('category', CategoryController::class);
//    ->middleware('auth:sanctum');

Route::post('/upload-icon/{category}', [ImageController::class, 'uploadIcon']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/register', [UserController::class, 'register']);
    Route::post('/auth/logout', [UserController::class, 'logout']);
});
