<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

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

// Author Routes
Route::post('/authors', [AuthorController::class, 'store']);
Route::get('/authors', [AuthorController::class, 'index']); // General route for listing authors
Route::get('/authors/{id}/picture', [AuthorController::class, 'getPicture']); // Specific route for getting picture
Route::get('/authors/{id}', [AuthorController::class, 'show']); // Specific route for showing a single author
Route::put('/authors/{id}', [AuthorController::class, 'update']);
Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);
