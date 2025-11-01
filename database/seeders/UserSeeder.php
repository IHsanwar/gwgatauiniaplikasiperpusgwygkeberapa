<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@lib.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Petugas (Librarian)
        User::create([
            'name' => 'Petugas Andi',
            'email' => 'petugas@lib.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // Regular Users
        User::factory()->count(3)->create([
            'role' => 'user'
        ]);
    }
}
