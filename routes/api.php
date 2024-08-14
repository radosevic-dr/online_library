<?php

use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/register', [UserController::class, 'register']);
    Route::post('/auth/logout', [UserController::class, 'logout']); 

    // Publisher routes

    Route::post('/auth/publishers/create', [PublisherController::class, 'createPublisher'])->name('publishers.create');

    Route::get('/auth/publishers/{id}', [PublisherController::class, 'viewPublisher'])->middleware('checkLibrarian')->name('publishers.view');

    Route::get('/auth/publishers/{publisher}/logo', [PublisherController::class, 'getPublisherLogo'])->name('publishers.logo');
});
