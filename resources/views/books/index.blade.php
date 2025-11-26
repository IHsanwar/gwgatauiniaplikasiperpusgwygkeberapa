@extends('layouts.app2')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="bi bi-book-half text-indigo-600 me-3"></i> 
                Koleksi Buku Kami
            </h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('profile.main') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition">
                    <i class="bi bi-arrow-left me-2"></i>
                    <span>Cek profil dan buku yang kamu pinjam</span>
                </a>
            </div>
            <div class="text-sm text-gray-500">
                <i class="bi bi-collection-fill me-1"></i>
                {{ $books->total() ?? count($books) }} Buku
            </div>
        </div>
        <p class="text-gray-600">Jelajahi koleksi buku digital dan fisik terlengkap</p>
        
    </div>

    <!-- Search and Borrow Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
        
        <!-- Search Book Card -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-md p-6 border border-blue-100">
            <div class="flex items-center mb-4">
                <div class="bg-blue-600 rounded-full p-2 me-3">
                    <i class="bi bi-search text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Cari Buku</h3>
                    <p class="text-xs text-gray-600">Temukan buku berdasarkan judul atau penulis</p>
                </div>
            </div>
            
            <form action="{{ route('books.search') }}" method="POST">
                @csrf
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            name="query"  
                            placeholder="Ketik judul atau nama penulis..."
                            class="pl-10 pr-4 py-3 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            value="{{ request('query') }}"
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm transition duration-200 font-medium flex items-center">
                        <i class="bi bi-search me-2"></i>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Borrow Card -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-md p-6 border border-green-100">
            <div class="flex items-center mb-4">
                <div class="bg-green-600 rounded-full p-2 me-3">
                    <i class="bi bi-upc-scan text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Pinjam Cepat</h3>
                    <p class="text-xs text-gray-600">Pinjam buku langsung dengan ISBN</p>
                </div>
            </div>
            
            <form action="{{ route('borrow.by.isbn') }}" method="POST">
                @csrf
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <i class="bi bi-upc absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            name="isbn"  
                            placeholder="Masukkan kode ISBN..."
                            class="pl-10 pr-4 py-3 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm transition duration-200 font-medium flex items-center">
                        <i class="bi bi-lightning-charge-fill me-2"></i>
                        Pinjam
                    </button>
                </div>
            </form>
        </div>
    </div>

    

    <!-- Books Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($books as $book)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col group">
                
                <!-- Book Cover with Overlay -->
                <div class="h-64 w-full bg-gradient-to-br from-gray-100 to-gray-200 relative overflow-hidden">
                    @if($book->image_url)
                        <img 
                            src="{{ $book->image_url }}" 
                            alt="{{ $book->title }}"
                            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                            onerror="this.src='https://via.placeholder.com/300x400?text=No+Image';"
                        >
                    @else
                        <div class="h-full w-full flex items-center justify-center">
                            <div class="text-center">
                                <i class="bi bi-book text-5xl text-gray-300 mb-2"></i>
                                <p class="text-gray-400 text-sm">Sampul tidak tersedia</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Availability Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shadow-lg
                            {{ $book->available() > 0 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            <i class="bi {{ $book->available() > 0 ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} me-1"></i>
                            {{ $book->available() > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>

                    <!-- Online Badge -->
                    @if($book->is_online)
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white shadow-lg">
                                <i class="bi bi-laptop me-1"></i>
                                Online
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Book Info -->
                <div class="p-5 flex-grow flex flex-col">
                    <h3 class="font-bold text-lg text-gray-800 line-clamp-2 mb-2 group-hover:text-indigo-600 transition">
                        {{ $book->title }}
                    </h3>
                    
                    <div class="flex items-center text-sm text-gray-600 mb-3">
                        <i class="bi bi-person-fill text-gray-400 me-2"></i>
                        <span class="line-clamp-1">{{ $book->author }}</span>
                    </div>

                    <!-- Book Meta Info -->
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                        <span class="flex items-center">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $book->published_year ?? 'N/A' }}
                        </span>
                        <span class="flex items-center">
                            <i class="bi bi-collection me-1"></i>
                            {{ $book->stock ?? 0 }} eksemplar
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto space-y-2">
                        @if($book->is_online)
                            <a href="{{ asset($book->file_url) }}" 
                               target="_blank" 
                               class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                <i class="bi bi-book-half me-2"></i>
                                Baca Online
                            </a>
                        @endif
                        
                        @if($book->available() > 0)
                            <a href="{{ route('borrow.create', $book) }}"
                               class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm font-medium rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                <i class="bi bi-bookmark-plus-fill me-2"></i>
                                Pinjam Buku
                            </a>
                        @else
                            <button disabled
                                    class="w-full px-4 py-2 bg-gray-200 text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed flex items-center justify-center">
                                <i class="bi bi-x-circle me-2"></i>
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination (if applicable) -->
    @if(method_exists($books, 'links'))
        <div class="mt-8">
            {{ $books->links() }}
        </div>
    @endif

    <!-- Empty State -->
    @if(count($books) === 0)
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <i class="bi bi-inbox text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak ada buku ditemukan</h3>
            <p class="text-gray-600">Coba ubah kata kunci pencarian Anda</p>
        </div>
    @endif
</div>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#10b981',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: "{{ session('info') }}",
            confirmButtonColor: '#3b82f6',
            confirmButtonText: 'OK'
        });
    @endif
</script>

@endsection