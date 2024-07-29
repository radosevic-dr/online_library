<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CategoryController;
=======
>>>>>>> a64beaee9aa87897955da6978fe6a066998ada2c

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

<<<<<<< HEAD
Route::apiResource('category', CategoryController::class);

Route::post('/upload-icon', [ImageController::class, 'uploadIcon']);
=======
// Author Routes
Route::post('/authors', [AuthorController::class, 'store']);
>>>>>>> a64beaee9aa87897955da6978fe6a066998ada2c
