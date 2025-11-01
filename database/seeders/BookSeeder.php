<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Book::insert([
            ['title' => 'Laravel untuk Pemula', 'author' => 'Budi Santoso', 'isbn' => '978-1234567890', 'stock' => 3],
            ['title' => 'Belajar PHP Modern', 'author' => 'Siti Rahayu', 'isbn' => '978-0987654321', 'stock' => 2],
            ['title' => 'Algoritma dan Struktur Data', 'author' => 'Agus Prasetyo', 'isbn' => '978-1122334455', 'stock' => 5],
            ['title' => 'Pemrograman Web dengan Tailwind', 'author' => 'Dewi Lestari', 'isbn' => '978-6677889900', 'stock' => 1],
            ['title' => 'Dasar-Dasar Database MySQL', 'author' => 'Eko Nugroho', 'isbn' => '978-5544332211', 'stock' => 4],
        ]);
    }
}
