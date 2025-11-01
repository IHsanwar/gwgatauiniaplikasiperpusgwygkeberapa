<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
class BorrowingController extends Controller
{
    // app/Http/Controllers/BorrowingController.php

public function create(Book $book)
{
    if ($book->available() <= 0) {
        abort(403, 'Buku tidak tersedia');
    }
    return view('borrowings.create', compact('book'));
}

public function store(Request $request, Book $book)
{
    if ($book->available() <= 0) {
        return back()->withErrors(['Buku tidak tersedia untuk dipinjam.']);
    }

    Borrowing::create([
        'user_id' => auth()->id(),
        'book_id' => $book->id,
        'borrowed_at' => $request->borrowed_at,
        'due_at' => $request->due_at,
        'status' => 'pending'
    ]);

    return redirect()->route('borrow.success');
}
}
