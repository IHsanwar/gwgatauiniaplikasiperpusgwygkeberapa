<?php

namespace App\Http\Controllers;
use App\Models\Book;
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
        'status' => 'pending_borrowing'
    ]);

    return redirect()->route('borrowing.success');
}

    public function accBorrowingBook(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'borrowed',
            'borrowed_at' => now(),
            'due_at' => now()->addDays(14) // misal jangka waktu pinjam 14 hari
        ]);

        return redirect()->route('borrowing.list')->with('success', 'Peminjaman disetujui.');
    }


    public function showReturn()
    {
        $borrowings = auth()->user()->borrowings()->with('book')->get();
        return view('borrowings.return', compact('borrowings'));
    }

    public function requestReturn(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'pending_return'
        ]);
        return back()->with('success', 'Permintaan pengembalian telah dikirim.');
    }

    public function accReturnBook(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'returned',
            'returned_at' => now()
        ]);
        //update stock book
        $book = $borrowing->book;
        $book->increment('stock');
        return redirect()->route('borrowings.index')->with('success', 'Pengembalian disetujui.');
    }

    public function index()
    {
        $borrowings = Borrowing::with('book', 'user')->get();
        return view('petugas.index', compact('borrowings'));
    }
}
