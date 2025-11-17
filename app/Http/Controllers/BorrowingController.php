<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Borrowing;
use Maatwebsite\Excel\Facades\Excel;

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

    return redirect()->route('dashboard')->with('success', 'Permintaan peminjaman berhasil dikirim.');
}

    public function accBorrowingBook(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'borrowed',
            'borrowed_at' => now(),
            'due_at' => now()->addDays(14)
        ]);

        $book = $borrowing->book;
        $book->decrement('stock');

        return redirect()->route('petugas.dashboard')->with('success', 'Peminjaman disetujui.');
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

        // stok bertambah
        $book = $borrowing->book;
        $book->increment('stock');

        return redirect()->route('petugas.dashboard')->with('success', 'Pengembalian disetujui.');
    }


    public function index(Request $request)
{
    $query = Borrowing::with('book', 'user');

    // Filter Status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Filter Tanggal
    if ($request->date) {
        $query->whereDate('borrowed_at', $request->date);
    }

    // Urut paling baru + pagination
    $borrowings = $query->orderBy('created_at', 'desc')->paginate(10);

    // Summary Cards
    $totalBorrowings = Borrowing::count();
    $pendingBorrow = Borrowing::where('status', 'pending_borrowing')->count();
    $borrowed = Borrowing::where('status', 'borrowed')->count();
    $pendingReturn = Borrowing::where('status', 'pending_return')->count();

    return view('petugas.index', compact(
        'borrowings',
        'totalBorrowings',
        'pendingBorrow',
        'borrowed',
        'pendingReturn'
    ));
    
}
    public function borrowingExportPdf(Request $request)
{
    $borrowings = Borrowing::with('book', 'user')
        ->orderBy('created_at', 'desc')
        ->get();

    $pdf = \PDF::loadView('report.borrowings_pdf', compact('borrowings'));

    return $pdf->download('laporan_peminjaman.pdf');
}
    

    public function borrowingExportExcel()
{
    return Excel::download(new \App\Exports\BorrowingsExport, 'laporan_peminjaman.xlsx');
}



}
