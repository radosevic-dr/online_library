<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [UserController::class, 'login']);

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {

    Route::post('/auth/logout', [UserController::class, 'logout']);
});
