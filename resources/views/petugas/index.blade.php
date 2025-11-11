@extends('layouts.admin')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Permintaan Peminjaman</h2>
        <a href="{{ route('dashboard') }}" class="inline-block px-3 py-1 text-sm text-red-600 bg-red-50 rounded-md hover:bg-red-100">⟵ Kembali</a>
    </div>

    @if($borrowings->isEmpty())
        <p class="text-gray-600">Tidak ada permintaan peminjaman.</p>
    @else
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Buku</th>
                        <th class="px-4 py-3">Pemohon</th>
                        <th class="px-4 py-3 text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-3 text-center">Jatuh Tempo</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($borrowings as $i => $borrowing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $borrowing->book->title ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $borrowing->user->name ?? '—' }}<br>
                                <span class="text-xs text-gray-500">{{ $borrowing->user->email ?? '' }}</span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm">
                                    {{ $borrowing->borrowed_at ? date('d M Y', strtotime($borrowing->borrowed_at)) : '—' }}

                                </td>
                                <td class="px-4 py-3 text-center text-sm">
                                    {{ $borrowing->due_at ? date('d M Y', strtotime($borrowing->due_at)) : '—' }}
                                </td>
                            <td class="px-4 py-3 text-center">
                                @if($borrowing->status === 'pending_borrowing')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Pending</span>
                                @elseif($borrowing->status === 'borrowed')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Borrowed</span>
                                @elseif($borrowing->status === 'pending_return')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">Returned</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700">{{ ucfirst($borrowing->status) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @if($borrowing->status === 'pending_borrowing')
                                    <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Setujui permintaan peminjaman untuk \"{{ addslashes($borrowing->book->title ?? 'buku') }}\" oleh {{ addslashes($borrowing->user->name ?? '') }}?')"
                                                class="px-3 py-1 text-xs font-medium rounded bg-emerald-500 hover:bg-emerald-600 text-white">
                                            Setujui
                                        </button>
                                    </form>
                                @elseif($borrowing->status === 'pending_return')
                                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Tandai buku sebagai dikembalikan?')"
                                                class="px-3 py-1 text-xs font-medium rounded bg-blue-500 hover:bg-blue-600 text-white">
                                            Terima Pengembalian
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-500">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection