@extends('layouts.admin')

@section('content')
<div class="bg-white shadow-md rounded-lg p-8 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Pengguna</h2>
        <a href="{{ route('dashboard') }}" 
           class="inline-block px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition">
           ⟵ Kembali ke Dashboard
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    @if($users->isEmpty())
        <p class="text-gray-600 text-sm">Tidak ada pengguna yang terdaftar.</p>
    @else
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 font-semibold">#</th>
                        <th class="px-6 py-3 font-semibold min-w-[180px]">Nama</th>
                        <th class="px-6 py-3 font-semibold min-w-[220px]">Email</th>
                        <th class="px-6 py-3 font-semibold text-center">Peran</th>
                        <th class="px-6 py-3 font-semibold text-center">Terdaftar</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Admin</span>
                                @elseif ($user->role === 'petugas')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Petugas</span>
                                
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="inline-block px-3 py-1 text-sm text-blue-600 border border-blue-500 rounded-md hover:bg-blue-50 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-block px-3 py-1 text-sm text-red-600 border border-red-500 rounded-md hover:bg-red-50 transition"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
