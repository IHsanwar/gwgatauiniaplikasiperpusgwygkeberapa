@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class ="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><i class="bi bi-book-half"></i> Manajemen koleksi buku saat ini</h1>
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('admin.books.create') }}" 
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded shadow">
            <i class="bi bi-plus-lg mr-1"></i> Tambah Buku Baru</a>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($books as $book)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col">
                <!-- Fixed-size book cover -->
                <div class="h-64 w-full bg-gray-100 flex items-center justify-center">
                    @if($book->image_url)
                        <img 
                            src="{{ $book->image_url }}" 
                            alt="{{ $book->title }}"
                            class="h-full w-full object-cover"
                            onerror="this.src='https://via.placeholder.com/300x400?text=No+Image';"
                        >
                    @else
                        <span class="text-gray-400 text-sm text-center px-4">
                            <i class="bi bi-book"></i> Sampul tidak tersedia
                        </span>
                    @endif
                </div>

                <!-- Book info -->
                <div class="p-4 flex-grow flex flex-col">
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-2">{{ $book->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">oleh {{ $book->author }}</p>

                    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $book->available() > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $book->available() > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                        <div class="flex space-x-2">
                        <a href="{{ route('admin.books.edit', $book->id) }}" 
                           class="text-sm text-blue-600 hover:bg-blue-300 flex items-center bg-blue-50 px-2 py-1 rounded-md">
                            <i class="bi bi-pencil-square mr-1"></i> Edit
                            </a>
                        <a href="{{ route('admin.books.destroy', $book->id) }}" 
                           class="text-sm text-red-600 hover:bg-red-300 flex items-center bg-red-50 px-2 py-1 rounded-md"
                           onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus buku ini?')) { document.getElementById('delete-book-{{ $book->id }}').submit(); }">
                            <i class="bi bi-trash-fill mr-1"></i> Hapus</a>
                            <form id="delete-book-{{ $book->id }}" action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection