@extends('layouts.app2')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><i class="bi bi-book-half"></i> Koleksi buku kami</h1>
   <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

    <!-- Form Search Buku -->
    <form action="{{ route('books.search') }}" method="POST" class="w-full">
        @csrf
        <div class="flex gap-2">
            <input 
                type="text" 
                name="query"  
                placeholder="Cari buku berdasarkan judul atau penulis..."
                class="px-4 py-3 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                value="{{ request('query') }}"
            >
            <button 
                type="submit" 
                class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm transition">
                Cari
            </button>
        </div>
    </form>

    <!-- Form Pinjam Buku via ISBN -->
    <form action="{{ route('borrow.by.isbn') }}" method="POST" class="w-full">
        @csrf
        <div class="flex gap-2">
            <input 
                type="text" 
                name="isbn"  
                placeholder="Masukkan ISBN buku..."
                class="px-4 py-3 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-green-500 focus:border-green-500"
            >
            <button 
                type="submit" 
                class="px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm transition">
                Pinjam
            </button>
        </div>
    </form>

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

                        @if($book->available() > 0)
                            <a href="{{ route('borrow.create', $book) }}"
                               class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                Pinjam
                            </a>
                        @else
                            <span class="px-3 py-1.5 bg-gray-200 text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed">
                                Tidak Bisa
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33',
        });
    @endif
</script>

@endsection