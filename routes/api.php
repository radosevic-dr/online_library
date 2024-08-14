<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [UserController::class, 'login'])->name('user.login');

// Request password reset link
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Handle password reset
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/auth/logout', [UserController::class, 'logout'])->name('user.logout');

    Route::get('/auth/users/{role}', [UserController::class, 'viewUsers'])->middleware('checkLibrarian')->name('user.index');
    Route::get('/auth/users/{user}', [UserController::class, 'viewUser'])->middleware('checkLibrarian')->name('user.show');
    Route::get('/auth/users/{user}/profile_picture', [UserController::class, 'viewUserProfilePicture'])->middleware('checkLibrarian')->name('user.profilePicture');
    Route::put('/auth/user/update', [UserController::class, 'editUser'])->name('user.edit');
    Route::delete('/auth/user/{user}', [UserController::class, 'delete'])->name('user.delete');
});

