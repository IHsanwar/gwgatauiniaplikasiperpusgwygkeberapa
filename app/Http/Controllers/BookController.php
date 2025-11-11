<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Book;
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

    // Jika ada file gambar, simpan ke storage/public/books
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('books', 'public');
        $imageUrl = asset('storage/' . $path);
    }

    // Simpan data buku
    Book::create([
        'title' => $request->title,
        'author' => $request->author,
        'isbn' => $request->isbn,
        'stock' => $request->stock,
        'image_url' => $imageUrl, // simpan URL ke kolom ini
    ]);

    return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
}

    public function editBook(Book $book)
    {
        return view('books.edit', compact('book'));
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

        $book->update($request->only('title', 'author', 'isbn', 'stock'));

        if ($request->hasFile('image')) {
            $book->clearMediaCollection('images');
            $book->addMedia($request->file('image'))->toMediaCollection('images');
        }

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function deleteBook(Book $book)
    {
        $book->clearMediaCollection('images');
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}