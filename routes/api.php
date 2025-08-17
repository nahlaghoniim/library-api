<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowRecordController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\ReviewController;

// Public routes (optional)
Route::get('books', [BookController::class, 'index']);
Route::get('books/{id}', [BookController::class, 'show']);

Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/{id}', [AuthorController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('admin')->apiResource('users', UserController::class);

    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('borrow-records', BorrowRecordController::class);
    Route::apiResource('fines', FineController::class);
    Route::apiResource('reviews', ReviewController::class);

});
