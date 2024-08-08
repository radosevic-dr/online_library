<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/auth/register', [UserController::class, 'register']);
    Route::post('/auth/logout', [UserController::class, 'logout']);

    // Author Routes
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::get('/authors', [AuthorController::class, 'index']); // General route for listing authors
    Route::get('/authors/{author}/picture', [AuthorController::class, 'getPicture']); // Specific route for getting picture
    Route::get('/authors/{author}', [AuthorController::class, 'show']); // Specific route for showing a single author
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);
});
