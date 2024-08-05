<?php

use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Routes for genres
Route::get('genres', [GenreController::class, 'index'])->name('genres.index');
Route::post('genres', [GenreController::class, 'store'])->name('genres.store');
Route::get('genres/{id}', [GenreController::class, 'show'])->name('genres.show');
Route::put('genres/{id}', [GenreController::class, 'update'])->name('genres.update');
Route::delete('genres/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');
