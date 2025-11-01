@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto text-center py-12">
    <div class="text-green-500 text-5xl mb-4">✓</div>
    <h1 class="text-2xl font-bold">Peminjaman Berhasil!</h1>
    <p class="mt-2 text-gray-600">Silakan tunggu petugas memproses permintaan Anda.</p>
    <a href="{{ route('books.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Kembali ke daftar buku</a>
</div>
@endsection