<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;


Route::apiResource('category', CategoryController::class);

Route::post('/upload-icon', [ImageController::class, 'uploadIcon']);
