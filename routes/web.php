<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\Admin\UserController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
      // Book browsing

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    // Borrowing flow
    Route::get('/books/{book}/borrow', [BorrowingController::class, 'create'])->name('borrow.create');
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('borrow.store');
    Route::get('/borrowings/success', function () {
        return view('borrowings.success');
    })->name('borrow.success');

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::patch('/users/{user}/toggle-role', [UserController::class, 'toggleRole'])->name('admin.users.toggle');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
