<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;
class BookController extends Controller
{
    //
    public function index()
{
    $books = Book::all();
    return view('books.index', compact('books'));
}
    public function show(Book $book)
{
    return view('books.show', compact('book')); 

}
    

    // Admin functions
    public function indexAdmin()
    {
        $books = Book::all();
        return view('admin.books.index', compact('books'));
    }

    public function createBook()
    {
        return view('admin.books.create');
    }


    public function storeBook(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'isbn' => 'required|string|max:13|unique:books,isbn',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048',
    ]);

    $imageUrl = null;

    if ($request->hasFile('image')) {
        // simpan file ke storage/app/public/books
        $path = $request->file('image')->store('books', 'public');
        
        // simpan URL lengkap
        $imageUrl = asset('storage/' . $path);
    }

    Book::create([
        'title' => $request->title,
        'author' => $request->author,
        'isbn' => $request->isbn,
        'stock' => $request->stock,
        'image_url' => $imageUrl,
    ]);

    return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
}


    public function editBook(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }
    public function updateBook(Request $request, Book $book)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'isbn' => 'required|string|max:13|unique:books,isbn,' . $book->id,
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048',
    ]);

    // Perbarui data teks
    $book->update($request->only('title', 'author', 'isbn', 'stock'));

    // Jika ada gambar baru
    if ($request->hasFile('image')) {

        // Hapus gambar lama berdasarkan URL
        if ($book->image_url) {
            $oldPath = str_replace(asset('storage/') . '/', '', $book->image_url);

            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Upload gambar baru
        $newPath = $request->file('image')->store('books', 'public');

        // Simpan URL baru
        $book->update([
            'image_url' => asset('storage/' . $newPath)
        ]);
    }

    return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
}




    public function deleteBook(Book $book)
    {
        $book->clearMediaCollection('images');
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

        public function search(Request $request)
    {
        $query = $request->input('query');

        $books = Book::where('title', 'like', "%$query%")
                    ->orWhere('author', 'like', "%$query%")
                    ->get();

        return view('books.index', compact('books'))
            ->with('query', $query);
    }


    public function searchByISBN(Request $request)
    {
        $isbn = $request->input('isbn');
        $book = Book::where('isbn', $isbn)->first();

        if ($book) {
            return view('books.show', compact('book'));
        } else {
            return redirect()->back()->with('error', 'Buku dengan ISBN tersebut tidak ditemukan.');
        }
    }
    
    public function borrowByISBN(Request $request)
{
    $isbn = $request->input('isbn');
    $book = Book::where('isbn', $isbn)->first();

    if (!$book) {
        return redirect()->back()->with('error', 'Buku dengan ISBN tersebut tidak ditemukan.');
    }

    if ($book->available() <= 0) {
        return redirect()->back()->with('error', 'Stok buku habis dan tidak bisa dipinjam.');
    }

    return redirect()->route('borrow.create', $book);
}

}