<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [UserController::class, 'login'])->name('user.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/auth/logout', [UserController::class, 'logout'])->name('user.logout');

    //Routes for genres
    Route::middleware('checkLibrarian')->group(function () {
        Route::get('genres', [GenreController::class, 'index'])->name('genres.index');
        Route::post('genres', [GenreController::class, 'store'])->name('genres.store');
        Route::get('genres/{id}', [GenreController::class, 'show'])->name('genres.show');
        Route::put('genres/{id}', [GenreController::class, 'update'])->name('genres.update');
        Route::delete('genres/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');
    });

    // pass user id as parameter
    // don't forget to add logged user bearer token
    Route::get('/auth/users/{role}', [UserController::class, 'viewUsers'])->middleware('checkLibrarian')->name('user.index');
    Route::get('/auth/users/{user}', [UserController::class, 'viewUser'])->middleware('checkLibrarian')->name('user.show');
    Route::get('/auth/users/{user}/profile_picture', [UserController::class, 'viewUserProfilePicture'])->middleware('checkLibrarian')->name('user.profilePicture');
    Route::put('/auth/user/update', [UserController::class, 'editUser'])->name('user.edit');

    Route::delete('/auth/user/{user}', [UserController::class, 'delete'])->name('user.delete');

    // Author routes
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::post('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

    // Category routes
    Route::apiResource('category', CategoryController::class);
    Route::post('/upload-icon/{category}', [ImageController::class, 'uploadIcon']);
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/categories/{category}/icon', [CategoryController::class, 'showIcon'])->name('category.icon');


    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

});

Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{author}/picture', [AuthorController::class, 'getPicture']);
Route::get('/authors/{author}', [AuthorController::class, 'show']);
