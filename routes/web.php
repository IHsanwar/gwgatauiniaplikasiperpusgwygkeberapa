<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\Admin\UserController;
Route::get('/', function () {
    return view('welcome');
});
Route::post('/books/search', [BookController::class, 'search'])->name('books.search');

Route::post('/borrow/isbn', [BookController::class, 'borrowByISBN'])->name('borrow.by.isbn');


Route::middleware('auth')->group(function () {
      // Book browsing

    Route::get('/dashboard', [BookController::class, 'index'])->name('dashboard');
    // Borrowing flow
    Route::get('/books/{book}/borrow', [BorrowingController::class, 'create'])->name('borrow.create');
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('borrow.store');
    Route::get('/borrowings/success', function () {
        return view('borrowings.success');
    })->name('borrow.success');

    
    Route::post('/search', [BookController::class, 'search'])->name('books.search');
    // Borrowing return
    Route::get('/borrowings/return', [BorrowingController::class, 'showReturn'])->name('borrowings.showReturn');
    Route::patch('/borrowings/{borrowing}/user-return', [BorrowingController::class, 'userReturn'])->name('borrowings.userReturn');
    
    Route::post('/borrowings/{borrowing}/request-return', [BorrowingController::class, 'requestReturn'])->name('borrowings.requestReturn');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::patch('/users/{user}/toggle-role', [UserController::class, 'toggleRole'])->name('admin.users.toggle');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

       
    });
    Route::middleware(['role:petugas,admin'])->prefix('master')->group(function () {
        // Book management
        Route::get('/books', [BookController::class, 'indexAdmin'])->name('admin.books.index');
        Route::get('/books/create', [BookController::class, 'createBook'])->name('admin.books.create');
        Route::post('/books', [BookController::class, 'storeBook'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'editBook'])->name('admin.books.edit');
        Route::put('/books/{book}', [BookController::class, 'updateBook'])->
        name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroyBook'])->name('books.destroy');
    });
    Route::middleware(['role:petugas'])->prefix('petugas')->group(function () {
        Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'accBorrowingBook'])->name('borrowings.approve');
        Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'accReturnBook'])->name('borrowings.return');
        Route::get('/dashboard', [BorrowingController::class, 'index'])->name('petugas.dashboard');
    });
    Route::get('/borrowings/export/pdf', [BorrowingController::class, 'borrowingExportPdf'])->name('borrowings.export.pdf');
    Route::get('/borrowings/export/excel', [BorrowingController::class, 'borrowingExportExcel'])->name('borrowings.export.excel');



    Route::get('/profile-main', [ProfileController::class, 'mainProfile'])->name('profile.main');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
