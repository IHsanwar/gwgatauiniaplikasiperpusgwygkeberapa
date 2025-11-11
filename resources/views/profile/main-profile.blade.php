@extends('layouts.app2')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-white shadow-md rounded-lg p-8 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-3xl font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
                <p class="text-gray-600 text-sm mt-1">{{ Auth::user()->email }}</p>
            </div>
            <a href="{{ route('profile.edit') }}" 
               class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow transition">
                Edit Profil
            </a>
        </div>
        
        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
            <div>
                <span class="font-medium text-gray-700">Email:</span>
                <p>{{ Auth::user()->email }}</p>
            </div>
            <div>
                <span class="font-medium text-gray-700">Terdaftar:</span>
                <p>{{ Auth::user()->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Borrowed Books Section -->
    <div class="bg-white shadow-md rounded-lg p-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Buku yang Dipinjam</h3>
    <button class="mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
            onclick="alert('Fitur pengembalian buku belum tersedia.');">
        Kembalikan Buku
    </button>
        @if($borrowings->isEmpty())
            <p class="text-gray-600 text-center py-8">Anda belum meminjam buku apapun.</p>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Judul Buku</th>
                            <th class="px-4 py-3">Pengarang</th>
                            <th class="px-4 py-3 text-center">Tanggal Pinjam</th>
                            <th class="px-4 py-3 text-center">Jatuh Tempo</th>
                            <th class="px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($borrowings as $index => $borrowing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $borrowing->book->title ?? '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $borrowing->book->author ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm">
                                    {{ $borrowing->borrowed_at ? date('d M Y', strtotime($borrowing->borrowed_at)) : '—' }}

                                </td>
                                <td class="px-4 py-3 text-center text-sm">
                                    {{ $borrowing->due_at ? date('d M Y', strtotime($borrowing->due_at)) : '—' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($borrowing->status === 'pending')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                            Menunggu
                                        </span>
                                    @elseif($borrowing->status === 'borrowed')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            Dipinjam
                                        </span>

                                        <!-- Tombol Kembalikan Buku -->
                                        <form action="{{ route('borrowings.requestReturn', $borrowing) }}" method="POST" class="inline-block mt-2">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin mengembalikan buku \"{{ addslashes($borrowing->book->title) }}\"?')"
                                                class="px-3 py-1 text-xs bg-green-600 hover:bg-green-700 text-white font-medium rounded transition">
                                                Kembalikan Buku
                                            </button>
                                        </form>
                                    @elseif($borrowing->status === 'pending_return')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Menunggu Pengembalian
                                        </span>
                                    @elseif($borrowing->status === 'returned')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700">
                                            {{ ucfirst($borrowing->status) }}
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection