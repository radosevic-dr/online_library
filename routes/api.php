<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/auth/register', [UserController::class, 'register']);
    Route::post('/auth/logout', [UserController::class, 'logout']);

    // pass user id as parameter
    // dont forget to add logged user bearer token 
    Route::get('/auth/user/{user}', [UserController::class, 'viewUser']);
    Route::put('/auth/user/update', [UserController::class, 'editUser']);

    Route::delete('/auth/user/{user}', [UserController::class, 'delete']);
});
