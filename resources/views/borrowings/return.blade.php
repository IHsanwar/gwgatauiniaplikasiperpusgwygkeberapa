@extends('layouts.app2')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded-lg p-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Kembalikan Buku</h2>
            <a href="{{ route('profile.main') }}" 
               class="text-sm text-blue-600 hover:underline">← Kembali ke Profil</a>
        </div>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Borrowed Books List -->
        @if($borrowings->isEmpty())
            <p class="text-gray-600 text-center py-8">Anda tidak memiliki buku yang sedang dipinjam.</p>
        @else
            <div class="space-y-4">
                @foreach($borrowings as $borrowing)
                    @if($borrowing->status === 'borrowed')
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $borrowing->book->title }}</h3>
                                    <p class="text-sm text-gray-600">Pengarang: {{ $borrowing->book->author }}</p>
                                    <p class="text-sm text-gray-600">ISBN: {{ $borrowing->book->isbn }}</p>
                                </div>
                                @if($borrowing->book->image_url)
                                    <img src="{{ $borrowing->book->image_url }}" 
                                         alt="{{ $borrowing->book->title }}" 
                                         class="w-20 h-28 object-cover rounded ml-4">
                                @endif
                            </div>

                            <div class="grid grid-cols-3 gap-4 mb-6 text-sm">
                                <div class="bg-blue-50 p-3 rounded">
                                    <span class="text-gray-600">Tanggal Pinjam</span>
                                    <p class="font-semibold text-gray-800">{{ optional($borrowing->borrowed_at)->format('d M Y') }}</p>
                                </div>
                                <div class="bg-amber-50 p-3 rounded">
                                    <span class="text-gray-600">Jatuh Tempo</span>
                                    <p class="font-semibold text-gray-800">{{ optional($borrowing->due_at)->format('d M Y') }}</p>
                                </div>
                                <div class="bg-green-50 p-3 rounded">
                                    <span class="text-gray-600">Status</span>
                                    <p class="font-semibold text-green-700">Dipinjam</p>
                                </div>
                            </div>

                            <!-- Return Form -->
                            <form action="{{ route('borrowings.userReturn', $borrowing) }}" method="POST" class="flex gap-3">
                                @csrf
                                @method('PATCH')
                                
                                <button type="submit"
                                        onclick="return confirm('Yakin ingin mengembalikan buku \"{{ addslashes($borrowing->book->title) }}\"?')"
                                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition">
                                    Kembalikan Buku
                                </button>
                                <a href="{{ route('profile.main') }}"
                                   class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-md transition">
                                    Batal
                                </a>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection