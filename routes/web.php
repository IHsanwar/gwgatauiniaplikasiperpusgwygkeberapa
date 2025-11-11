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

    // Borrowing return
    Route::get('/borrowings/return', [BorrowingController::class, 'showReturn'])->name('borrowings.showReturn');
    Route::patch('/borrowings/{borrowing}/user-return', [BorrowingController::class, 'userReturn'])->name('borrowings.userReturn');
    
    Route::post('/borrowings/{borrowing}/request-return', [BorrowingController::class, 'requestReturn'])->name('borrowings.requestReturn');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::patch('/users/{user}/toggle-role', [UserController::class, 'toggleRole'])->name('admin.users.toggle');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

       
    });
    Route::middleware(['role:petugas,admin'])->prefix('admin')->group(function () {
        // Book management
        Route::get('/books', [BookController::class, 'indexAdmin'])->name('admin.books.index');
        Route::get('/books/create', [BookController::class, 'createBook'])->name('admin.books.create');
        Route::post('/books', [BookController::class, 'storeBook'])->name('books.store');
    });
    Route::middleware(['role:petugas'])->prefix('petugas')->group(function () {
        Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'accBorrowingBook'])->name('borrowings.approve');
        Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'accReturnBook'])->name('borrowings.return');
        Route::get('/books-list', [BorrowingController::class, 'index'])->name('borrowing.list');
    });


    Route::get('/profile-main', [ProfileController::class, 'mainProfile'])->name('profile.main');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
