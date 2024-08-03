<?php
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


Route::post('/authors', [AuthorController::class, 'store']);


Route::post('/auth/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/auth/register', [UserController::class, 'register']);
    Route::post('/auth/logout', [UserController::class, 'logout']);
});

