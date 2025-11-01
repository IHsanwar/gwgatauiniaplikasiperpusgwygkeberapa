@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Proses Peminjaman</h1>
    <p class="mb-4">Buku: <strong>{{ $book->title }}</strong></p>

    <form method="POST" action="{{ route('borrow.store', $book) }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Tanggal Pinjam</label>
            <input type="date" name="borrowed_at" value="{{ now()->format('Y-m-d') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tanggal Kembali (7 hari)</label>
            <input type="date" name="due_at" value="{{ now()->addDays(7)->format('Y-m-d') }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Ajukan Peminjaman
        </button>
    </form>
</div>
@endsection