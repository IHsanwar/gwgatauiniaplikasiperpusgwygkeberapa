@extends('layouts.admin')

@section('content')
<div class="bg-white shadow-md rounded-lg p-8 max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Tambah Buku</h2>
        <a href="{{ route('dashboard') }}" 
           class="inline-block px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-md hover:bg-red-100 transition">
           ⟵ Kembali ke Daftar Buku
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
            <input id="title" name="title" type="text" value="{{ old('title', $book->title) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500" required>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="author" class="block text-sm font-medium text-gray-700">Pengarang</label>
            <input id="author" name="author" type="text" value="{{ old('author', $book->author) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500" required>
            @error('author') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                <input id="isbn" name="isbn" type="text" value="{{ old('isbn', $book->isbn) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500" required>
                @error('isbn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', 1) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500" required>
                @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Gambar Sampul (opsional)</label>
            <input id="image" name="image" type="file" accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-600 file:bg-red-500 file:text-white file:py-2 file:px-3 file:rounded-md">
            @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.books.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Batal</a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md shadow">
                Simpan Buku
            </button>
        </div>
    </form>
</div>
@endsection
