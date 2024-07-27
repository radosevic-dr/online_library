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



