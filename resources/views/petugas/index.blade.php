@extends('layouts.admin')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800"><i class="bi bi-building-gear"></i> Dashboard Petugas</h2>
        <a href="{{ route('dashboard') }}" class="inline-block px-3 py-1 text-sm text-red-600 bg-red-50 rounded-md hover:bg-red-100"><i class="bi bi-arrow-left-square"></i> Kembali</a>
    </div>

    <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#16a34a',
                });
            </script>
        @endif

        <form method="GET" class="flex flex-wrap gap-3 items-center">
            <select name="status" class="px-3 py-2 border rounded-md">
                <option value="">Semua Status</option>
                <option value="pending_borrowing" {{ request('status')=='pending_borrowing'?'selected':'' }}>Pending Borrow</option>
                <option value="borrowed" {{ request('status')=='borrowed'?'selected':'' }}>Borrowed</option>
                <option value="pending_return" {{ request('status')=='pending_return'?'selected':'' }}>Pending Return</option>
                <option value="returned" {{ request('status')=='returned'?'selected':'' }}>Returned</option>
            </select>

            <input type="date" name="date" value="{{ request('date') }}" class="px-3 py-2 border rounded-md">

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
               <i class="bi bi-funnel"></i> Filter
            </button>

            <a href="{{ route('petugas.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
              <i class="bi bi-arrow-repeat"></i>  Reset
            </a>
        </form>

        <div class="flex gap-2">
            <a href="{{ route('borrowings.export.pdf') }}" class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                <i class="bi bi-filetype-pdf"></i> Cetak PDF
            </a>

            <a href="{{ route('borrowings.export.excel') }}" class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                <i class="bi bi-filetype-xlsx"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white shadow rounded-lg border">
            <p class="text-sm text-gray-500"><i class="bi bi-layers"></i> Total Peminjaman</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $totalBorrowings }}</h3>
        </div>

        <div class="p-4 bg-white shadow rounded-lg border">
            <p class="text-sm text-gray-500"><i class="bi bi-calendar-check"></i> Menunggu Persetujuan</p>
            <h3 class="text-2xl font-bold text-amber-600">{{ $pendingBorrow }}</h3>
        </div>

        <div class="p-4 bg-white shadow rounded-lg border">
            <p class="text-sm text-gray-500"><i class="bi bi-archive"></i> Sedang Dipinjam</p>
            <h3 class="text-2xl font-bold text-green-600">{{ $borrowed }}</h3>
        </div>

        <div class="p-4 bg-white shadow rounded-lg border">
            <p class="text-sm text-gray-500"><i class="bi bi-arrow-counterclockwise"></i> Menunggu Pengembalian</p>
            <h3 class="text-2xl font-bold text-blue-600">{{ $pendingReturn }}</h3>
        </div>
    </div>

    @if($borrowings->isEmpty())
        <p class="text-gray-600 text-center"><i class="bi bi-x-octagon"></i> Tidak ada permintaan peminjaman.</p>
    @else
        <!-- Desktop / md+ Table -->
        <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-600 table-fixed">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 w-12">#</th>
                        <th class="px-4 py-3 w-40">Buku</th>
                        <th class="px-4 py-3 w-48">Pemohon</th>
                        <th class="px-4 py-3 w-36 text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-3 w-34 text-center">Jatuh Tempo</th>
                        <th class="px-4 py-3 w-30 text-center">Status</th>
                        <th class="px-4 py-3 w-44 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($borrowings as $i => $borrowing)
                        <tr class="hover:bg-gray-50 h-20">
                            <td class="px-4 py-3 align-middle">{{ $borrowings->firstItem() ? $borrowings->firstItem() + $i : $i + 1 }}</td>

                            <!-- Book title with image and truncation -->
                            <td class="px-4 py-3 align-middle">
                                <div class="flex items-center gap-3">
                                   <!--  <div class="w-12 h-16 flex-shrink-0 bg-gray-100 rounded overflow-hidden">
                                        @if($borrowing->book->image_url)
                                            <img src="{{ $borrowing->book->image_url }}" alt="{{ $borrowing->book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i class="bi bi-book"></i>
                                            </div>
                                        @endif 
                                    </div>-->
                                    <div class="truncate max-w-[160px]" title="{{ $borrowing->book->title ?? '-' }}">
                                        {{ \Illuminate\Support\Str::limit($borrowing->book->title ?? '-', 8, '...') }}
                                        <div class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($borrowing->book->author ?? '-', 12, '...') }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- User -->
                            <td class="px-4 py-3 align-middle">
                                <div class="truncate max-w-[180px]" title="{{ $borrowing->user->name ?? '-' }}">
                                    {{ \Illuminate\Support\Str::limit($borrowing->user->name ?? '-', 12, '...') }}
                                </div>
                                <div class="text-xs text-gray-500 truncate max-w-[180px]" title="{{ $borrowing->user->email ?? '' }}">
                                    {{ \Illuminate\Support\Str::limit($borrowing->user->email ?? '', 18, '...') }}
                                </div>
                            </td>

                            <!-- Dates -->
                            <td class="px-4 py-3 text-center align-middle text-sm">
                                {{ $borrowing->borrowed_at ? date('d M Y', strtotime($borrowing->borrowed_at)) : '—' }}
                            </td>
                            <td class="px-4 py-3 text-center align-middle text-sm">
                                {{ $borrowing->due_at ? date('d M Y', strtotime($borrowing->due_at)) : '—' }}
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3 text-center align-middle">
                                @if($borrowing->status === 'pending_borrowing')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Pending</span>
                                @elseif($borrowing->status === 'borrowed')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Borrowed</span>
                                @elseif($borrowing->status === 'pending_return')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">On returning</span>
                                @elseif($borrowing->status === 'returned')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Returned</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-700">{{ ucfirst($borrowing->status) }}</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right align-middle">
                                @if($borrowing->status === 'pending_borrowing')
                                    <button type="button"
                                            class="btn-approve w-28 px-3 py-1 text-xs font-medium rounded bg-emerald-500 hover:bg-emerald-600 text-white"
                                            data-title="{{ $borrowing->book->title }}"
                                            data-user="{{ $borrowing->user->name }}"
                                            data-url="{{ route('borrowings.approve', $borrowing) }}">
                                        Setujui
                                    </button>
                                @elseif($borrowing->status === 'pending_return')
                                    <button type="button"
                                            class="btn-return w-36 px-3 py-1 text-xs font-medium rounded bg-blue-500 hover:bg-blue-600 text-white"
                                            data-url="{{ route('borrowings.return', $borrowing) }}">
                                        Terima Pengembalian
                                    </button>
                                @else
                                    <span class="text-xs text-gray-500">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile: stacked cards with fixed height -->
        <div class="md:hidden space-y-3">
            @foreach($borrowings as $i => $borrowing)
                <div class="border rounded-lg p-4 flex justify-between items-start gap-4 h-36">
                    <div class="flex-shrink-0 w-20">
                        <div class="w-20 h-28 bg-gray-100 rounded overflow-hidden">
                    <!--        @if($borrowing->book->image_url)
                                <img src="{{ $borrowing->book->image_url }}" alt="{{ $borrowing->book->title }}" class="w-full h-full object-cover">
                            @else -->
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="bi bi-book"></i>
                                </div>
                          <!--  @endif -->
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <div class="truncate font-semibold" title="{{ $borrowing->book->title ?? '-' }}">
                                {{ \Illuminate\Support\Str::limit($borrowing->book->title ?? '-', 8, '...') }}
                            </div>
                            <div class="text-xs text-gray-500">{{ $borrowing->borrowed_at ? date('d M Y', strtotime($borrowing->borrowed_at)) : '—' }}</div>
                        </div>

                        <div class="text-sm text-gray-600 truncate mt-1" title="{{ $borrowing->book->author ?? '-' }}">
                            {{ \Illuminate\Support\Str::limit($borrowing->book->author ?? '-', 14, '...') }}
                        </div>

                        <div class="flex items-center justify-between mt-3">
                            <div class="text-xs text-gray-500">
                                <div title="{{ $borrowing->user->name ?? '-' }}">{{ \Illuminate\Support\Str::limit($borrowing->user->name ?? '-', 12, '...') }}</div>
                                <div title="{{ $borrowing->user->email ?? '' }}" class="truncate">{{ \Illuminate\Support\Str::limit($borrowing->user->email ?? '', 18, '...') }}</div>
                            </div>

                            <div>
                                @if($borrowing->status === 'pending_borrowing')
                                    <button type="button"
                                            class="btn-approve w-24 px-3 py-1 text-xs font-medium rounded bg-emerald-500 hover:bg-emerald-600 text-white"
                                            data-title="{{ $borrowing->book->title }}"
                                            data-user="{{ $borrowing->user->name }}"
                                            data-url="{{ route('borrowings.approve', $borrowing) }}">
                                        Setujui
                                    </button>
                                @elseif($borrowing->status === 'pending_return')
                                    <button type="button"
                                            class="btn-return w-32 px-3 py-1 text-xs font-medium rounded bg-blue-500 hover:bg-blue-600 text-white"
                                            data-url="{{ route('borrowings.return', $borrowing) }}">
                                        Terima
                                    </button>
                                @else
                                    <span class="text-xs text-gray-500">—</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        
    {{-- PAGINATION INFO + LINKS --}}
    <div class="mt-4 flex flex-col md:flex-row items-center justify-between gap-3">

        {{-- INFO --}}
        <p class="text-sm text-gray-500">
            Menampilkan 
            <span class="font-semibold">{{ $borrowings->firstItem() ?: 0 }}</span>
            -
            <span class="font-semibold">{{ $borrowings->lastItem() ?: 0 }}</span>
            dari 
            <span class="font-semibold">{{ $borrowings->total() }}</span> data
        </p>

        {{-- PAGINATION LINKS --}}
        <div class="pagination-area">
            {{ $borrowings->onEachSide(1)->withQueryString()->links('vendor.pagination.tailwind-custom') }}
        </div>
    </div>


    @endif
</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", () => {
    // APPROVE BORROWING
    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.addEventListener('click', function() {
            const title = this.dataset.title;
            const user = this.dataset.user;
            const url  = this.dataset.url;

            Swal.fire({
                title: 'Setujui Peminjaman?',
                html: `Buku: <b>${title}</b><br>Pemohon: <b>${user}</b>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';

                    form.appendChild(token);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // RETURN BORROWING
    document.querySelectorAll('.btn-return').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.url;

            Swal.fire({
                title: 'Terima Pengembalian?',
                text: "Pastikan buku sudah diterima dengan baik.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Terima',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';

                    form.appendChild(token);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
