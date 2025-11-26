<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */

    use HasFactory; // <-- penting
    public $fillable = [
        'title',
        'author',
        'isbn',
        'stock',
        'image_url',
        'is_online',
        'file_url',

    ];

    public function borrowings()    
{
    return $this->hasMany(Borrowing::class);
}
    public function available()
    {
        if ($this->is_online) {
            return 'Online'; 
        }

        return $this->stock - $this->borrowings()
            ->where('status', '!=', 'returned')
            ->count();
    }

    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ebook')
             ->singleFile();
    }
}
