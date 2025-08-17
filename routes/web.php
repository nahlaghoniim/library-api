<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Temporary "login as admin" for testing
Route::get('/admin-dashboard-test', function () {
    $user = User::where('role', 'admin')->first();
    Auth::login($user); // Log in as admin
    return redirect()->route('admin.dashboard');
});

// Temporary "login as member" for testing
Route::get('/member-dashboard-test', function () {
    $user = User::where('role', 'member')->first();
    Auth::login($user); // Log in as member
    return redirect()->route('member.dashboard');
});


// Authenticated routes
Route::middleware('auth')->group(function() {

    // Dashboard redirect based on role
    Route::get('/dashboard', function() {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('member.dashboard');
            })->name('dashboard'); // ← add this name

    });

    // Admin routes
    Route::prefix('admin')->middleware('admin')->group(function() {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        // Add admin resource routes for books, authors, categories if needed
         Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Add resource routes for admin management
    Route::resource('books', \App\Http\Controllers\BookController::class, [
        'as' => 'admin' // This prefixes route names like admin.books.index
    ]);

    Route::resource('authors', \App\Http\Controllers\AuthorController::class, [
        'as' => 'admin'
    ]);

    Route::resource('loans', \App\Http\Controllers\LoanController::class, [
        'as' => 'admin'
    ]);
    });

    // Member routes
    Route::prefix('member')->group(function() {
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
        // Add borrow/return routes if you implement them
        // Route::post('/borrow/{book}', [MemberController::class, 'borrow'])->name('member.borrow');
        // Route::post('/return/{loan}', [MemberController::class, 'return'])->name('member.return');
    });

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); // back to home
})->name('logout');