<h2>Laporan Peminjaman Buku</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>#</th>
            <th>Buku</th>
            <th>Peminjam</th>
            <th>Tgl Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($borrowings as $i => $b)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $b->book->title }}</td>
            <td>{{ $b->user->name }}</td>
            <td>{{ $b->borrowed_at }}</td>
            <td>{{ $b->due_at }}</td>
            <td>{{ ucfirst($b->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
