<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;

class BookController extends Controller
{
    public function index()
{
    $books = Book::paginate(10);
    return view('books.index', compact('books'));
}


    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');

        $books = Book::where('title', 'like', '%' . $query . '%')
            ->orWhere('author', 'like', '%' . $query . '%')
            ->orWhere('isbn', 'like', '%' . $query . '%')
            ->paginate(10);

        return view('books.index', compact('books'));
    }

    // ===============================
    // ADMIN FUNCTIONS
    // ===============================

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
            'title'      => 'required|string|max:255',
            'author'     => 'required|string|max:255',
            'isbn'       => 'required|string|max:13|unique:books,isbn',
            'stock'      => 'required|integer|min:0',
            'image'      => 'nullable|image|max:2048',
            'is_online'  => 'sometimes|boolean',
            'file'   => 'nullable|file|mimes:pdf', // URL atau file ebook
        ]);

        $imageUrl = null;

        // Upload gambar cover
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('books', 'public');
            $imageUrl = asset('storage/' . $path);
        }

        $fileUrl = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('books/files', 'public');
            $fileUrl = asset('storage/' . $filePath);
        }

        Book::create([
            'title'     => $request->title,
            'author'    => $request->author,
            'isbn'      => $request->isbn,
            'stock'     => $request->stock,
            'image_url' => $imageUrl,
            'is_online' => $request->boolean('is_online'),
            'file_url'  => $fileUrl, // bisa berupa link Google Drive / PDF
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }


    public function editBook(Book $book)
    {
        $borrowedCount = $book->borrowings()
            ->where('status', 'borrowed')
            ->count();

        return view('admin.books.edit', compact('book', 'borrowedCount'));
    }


    public function updateBook(Request $request, Book $book)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'isbn'      => 'required|string|max:13|unique:books,isbn,' . $book->id,
            'stock'     => 'required|integer|min:0',
            'image'     => 'nullable|image|max:2048',
            'is_online' => 'sometimes|boolean',
            'file_url'  => 'nullable|string|max:255',
        ]);

        // Update field biasa
        $book->update([
            'title'     => $request->title,
            'author'    => $request->author,
            'isbn'      => $request->isbn,
            'stock'     => $request->stock,
            'is_online' => $request->boolean('is_online'),
            'file_url'  => $request->file_url,
        ]);

        // Jika ganti cover
        if ($request->hasFile('image')) {

            // hapus cover lama
            if ($book->image_url) {
                $oldPath = str_replace(asset('storage/') . '/', '', $book->image_url);

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // upload cover baru
            $newPath = $request->file('image')->store('books', 'public');

            $book->update([
                'image_url' => asset('storage/' . $newPath)
            ]);
        }

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }



    public function deleteBook(Book $book)
    {
        // Hapus cover jika ada
        if ($book->image_url) {
            $oldPath = str_replace(asset('storage/') . '/', '', $book->image_url);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }


    // ===============================
    // SEARCH & BORROW
    // ===============================

    public function searchByISBN(Request $request)
    {
        $isbn = $request->input('isbn');
        $book = Book::where('isbn', $isbn)->first();

        if ($book) {
            return view('books.show', compact('book'));
        }

        return redirect()->back()->with('error', 'Buku dengan ISBN tersebut tidak ditemukan.');
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
