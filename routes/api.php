<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;

Route::post('/auth/login', [UserController::class, 'login'])->name('user.login');


Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/reset-password/{token}', function (string $token) {
    return ['token' => $token];
})->middleware('guest')->name('password.reset');

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

        // pass user id as parameter
        // don't forget to add logged user bearer token
        Route::get('/auth/users/{role}', [UserController::class, 'viewUsers'])->middleware('checkLibrarian')->name('user.index');
        Route::get('/auth/users/{user}', [UserController::class, 'viewUser'])->middleware('checkLibrarian')->name('user.show');
        Route::get('/auth/users/{user}/profile_picture', [UserController::class, 'viewUserProfilePicture'])->middleware('checkLibrarian')->name('user.profilePicture');
        Route::put('/auth/user/update', [UserController::class, 'editUser'])->name('user.edit');
        Route::delete('/auth/user/{user}', [UserController::class, 'delete'])->name('user.delete');

        // Publisher routes

        Route::post('/auth/publishers/create', [PublisherController::class, 'createPublisher'])->name('publishers.create');
        Route::get('/auth/publishers/{id}', [PublisherController::class, 'viewPublisher'])->middleware('checkLibrarian')->name('publishers.view');
        Route::get('/auth/publishers/{publisher}/logo', [PublisherController::class, 'getPublisherLogo'])->name('publishers.logo');

        // Author routes

        Route::post('/authors', [AuthorController::class, 'store']);
        Route::post('/authors/{author}', [AuthorController::class, 'update']);
        Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

        Route::get('/authors', [AuthorController::class, 'index']);
        Route::get('/authors/{author}/picture', [AuthorController::class, 'getPicture']);
        Route::get('/authors/{author}', [AuthorController::class, 'show']);

        // Book routes
/*************  ✨ Codeium Command ⭐  *************/
        Route::post('/rent-a-book', [BookController::class, 'rent']);
        Route::get('/show-book-rental-history', [BookController::class, 'showRentalHistory'])->middleware('checkLibrarian')->name('books.bookRentalHistory');
    });

    // Category routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    Route::apiResource('category', CategoryController::class);
    Route::post('/upload-icon/{category}', [ImageController::class, 'uploadIcon']);

    Route::apiResource('categories', CategoryController::class)->only(['update']);
    Route::post('/categories/{category}/icon', [ImageController::class, 'updateIcon'])
        ->name('categories.updateIcon');

    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/categories/{category}/icon', [CategoryController::class, 'showIcon'])->name('category.icon');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{author}/picture', [AuthorController::class, 'getPicture']);
Route::get('/authors/{author}', [AuthorController::class, 'show']);
