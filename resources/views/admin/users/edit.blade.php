@extends('layouts.admin')

@section('content')
<div class="bg-white shadow-md rounded-lg p-8 max-w-2xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Pengguna</h2>
        <a href="{{ route('admin.users.index') }}" 
           class="inline-block px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition">
           ⟵ Kembali ke Daftar Pengguna
        </a>
    </div>

    <!-- Alert -->
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required>
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required>
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
            <select id="role" name="role"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Terdaftar -->
        <div class="bg-gray-50 p-4 rounded-md">
            <label class="block text-sm font-medium text-gray-700">Terdaftar</label>
            <p class="mt-1 text-gray-600">{{ $user->created_at->format('d M Y H:i') }}</p>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.users.index') }}" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit" 
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 shadow transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection