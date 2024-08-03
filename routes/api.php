<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;\
use App\Http\Controllers\Api\UserController;


Route::post('/authors', [AuthorController::class, 'store']);
Route::get('/authors', [AuthorController::class, 'index']); // General route for listing authors
Route::get('/authors/{id}/picture', [AuthorController::class, 'getPicture']); // Specific route for getting picture
Route::get('/authors/{id}', [AuthorController::class, 'show']); // Specific route for showing a single author
Route::put('/authors/{id}', [AuthorController::class, 'update']);
Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);

Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/auth/register', [UserController::class, 'register']);
    Route::post('/auth/logout', [UserController::class, 'logout']);
});
