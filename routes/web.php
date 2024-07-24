<?php

use App\Mail\LibraryEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

// Test mail
Route::get('/testmail', function () {
    $name = 'Mitar Miric';
    Mail::to('laravel@codeus.com')->send(new LibraryEmail($name));
});


Route::controller(CategoryController::class)->prefix('/categories')->group(function () {
    Route::get('', 'index');
    Route::view('/create', 'categoriesCreate');
    Route::post('', 'store')->name('categories.store');
    Route::get('/{category}', 'show')->name('categories.show');
});
