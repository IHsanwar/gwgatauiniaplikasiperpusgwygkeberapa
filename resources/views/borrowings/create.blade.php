@extends('layouts.app2')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Header with Back Button -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition mb-4">
            <i class="bi bi-arrow-left me-2"></i>
            <span>Kembali ke Daftar Buku</span>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            <i class="bi bi-journal-bookmark-fill text-black-600 me-3"></i>
            Proses Peminjaman
        </h1>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Book Details Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-t-0 border-indigo-600">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="bi bi-info-circle-fill text-indigo-600 me-2"></i>
                Detail Buku
            </h2>
            
            <div class="space-y-4">
                <!-- Title -->
                <div class="flex items-start">
                    <div class="bg-indigo-100 rounded-full p-2 me-3 flex-shrink-0">
                        <i class="bi bi-book text-indigo-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Judul Buku</p>
                        <p class="font-semibold text-gray-800">{{ $book->title }}</p>
                    </div>
                </div>

                <!-- Author -->
                <div class="flex items-start">
                    <div class="bg-purple-100 rounded-full p-2 me-3 flex-shrink-0">
                        <i class="bi bi-person-fill text-purple-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Pengarang</p>
                        <p class="font-semibold text-gray-800">{{ $book->author }}</p>
                    </div>
                </div>

                <!-- ISBN -->
                <div class="flex items-start">
                    <div class="bg-blue-100 rounded-full p-2 me-3 flex-shrink-0">
                        <i class="bi bi-upc-scan text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">ISBN</p>
                        <p class="font-semibold text-gray-800">{{ $book->isbn }}</p>
                    </div>
                </div>

                <!-- Published Year -->
                <div class="flex items-start">
                    <div class="bg-green-100 rounded-full p-2 me-3 flex-shrink-0">
                        <i class="bi bi-stack text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Sisa Stok</p>
                        <p class="font-semibold text-gray-800">{{ $book->stock }}</p>
                    </div>
                </div>

                <!-- Currently Borrowed -->
                <div class="mt-6 p-4 bg-amber-50 border-l-4 border-amber-500 rounded">
                    <div class="flex items-center">
                        <i class="bi bi-people-fill text-amber-600 text-xl me-3"></i>
                        <div>
                            <p class="text-sm text-amber-700 font-medium">Status Peminjaman</p>
                            <p class="text-amber-900">
                                Saat ini dipinjam oleh <strong>{{ $curentlyBorrowedByMany }}</strong> orang
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrow Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-t-0 border-green-600">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                <i class="bi bi-clipboard-check-fill text-green-600 me-2"></i>
                Form Peminjaman
            </h2>

            <form method="POST" action="{{ route('borrow.store', $book) }}" class="space-y-6">
                @csrf

                <!-- Borrowed Date -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                        <i class="bi bi-calendar-plus text-indigo-600 me-2"></i>
                        Tanggal Pinjam
                    </label>
                    <input 
                        type="date" 
                        name="borrowed_at" 
                        value="{{ now()->format('Y-m-d') }}" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                        required>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="bi bi-info-circle me-1"></i>
                        Tanggal mulai peminjaman buku
                    </p>
                </div>

                <!-- Due Date -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                        <i class="bi bi-calendar-check text-green-600 me-2"></i>
                        Tanggal Kembali
                    </label>
                    <input 
                        type="date" 
                        name="due_at" 
                        value="{{ now()->addDays(7)->format('Y-m-d') }}" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" 
                        required>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="bi bi-info-circle me-1"></i>
                        Batas waktu pengembalian (7 hari dari tanggal pinjam)
                    </p>
                </div>

                <!-- Info Box -->
                

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200 flex items-center justify-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Ajukan Peminjaman
                </button>
            </form>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="mt-8 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="bi bi-question-circle-fill text-indigo-600 me-2"></i>
            Syarat dan Ketentuan Peminjaman
        </h3>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="flex items-start">
                <div class="bg-white rounded-full p-2 me-3 shadow-sm">
                    <i class="bi bi-shield-check text-indigo-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Akun Terverifikasi</p>
                    <p class="text-xs text-gray-600">Akun harus aktif dan terverifikasi</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="bg-white rounded-full p-2 me-3 shadow-sm">
                    <i class="bi bi-clock-history text-indigo-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Tepat Waktu</p>
                    <p class="text-xs text-gray-600">Kembalikan buku sesuai jadwal</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="bg-white rounded-full p-2 me-3 shadow-sm">
                    <i class="bi bi-heart-fill text-indigo-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Rawat Buku</p>
                    <p class="text-xs text-gray-600">Jaga kondisi buku dengan baik</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection