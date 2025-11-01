<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    public $fillable = [
        'title',
        'author',
        'isbn',
        'stock',
    ];

    public function borrowings()
{
    return $this->hasMany(Borrowing::class);
}

public function available()
{
    return $this->stock - $this->borrowings()->where('status', '!=', 'returned')->count();
}
}
