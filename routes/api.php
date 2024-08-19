<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [UserController::class, 'login'])->name('user.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/auth/logout', [UserController::class, 'logout'])->name('user.logout');

    // pass user id as parameter
    // dont forget to add logged user bearer token
    Route::get('/auth/users/{role}', [UserController::class, 'viewUsers'])->middleware('checkLibrarian')->name('user.index');
    Route::get('/auth/users/{user}', [UserController::class, 'viewUser'])->middleware('checkLibrarian')->name('user.show');
    Route::get('/auth/users/{user}/profile_picture', [UserController::class, 'viewUserProfilePicture'])->middleware('checkLibrarian')->name('user.profilePicture');
    Route::put('/auth/user/update', [UserController::class, 'editUser'])->name('user.edit');

    Route::delete('/auth/user/{user}', [UserController::class, 'delete'])->name('user.delete');

    Route::post('/authors', [AuthorController::class, 'store']);
    Route::post('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);
});

Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{author}/picture', [AuthorController::class, 'getPicture']);
Route::get('/authors/{author}', [AuthorController::class, 'show']);
