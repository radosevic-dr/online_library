<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Api\UserController;

Route::post('/authors', [AuthorController::class, 'store']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::get('/authors/{id}/picture', [AuthorController::class, 'getPicture']);
Route::put('/authors/{id}', [AuthorController::class, 'update']);
Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);

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
});
