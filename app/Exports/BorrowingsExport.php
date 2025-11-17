<?php
namespace App\Exports;

use App\Models\Borrowing;
use Maatwebsite\Excel\Concerns\FromCollection;

class BorrowingsExport implements FromCollection
{
    public function collection()
    {
        return Borrowing::with('book', 'user')->get()->map(function ($b) {
            return [
                'Buku' => $b->book->title,
                'Peminjam' => $b->user->name,
                'Pinjam' => $b->borrowed_at,
                'Jatuh Tempo' => $b->due_at,
                'Status' => $b->status,
            ];
        });
    }
}
