<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Models\Book;
// use App\Models\Author;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'website', 'email', 'phone', 'established_year',
    ];

    // public function books()
    // {
    //     return $this->hasMany(Book::class);
    // }

    // public function authors()
    // {
    //     return $this->belongsToMany(Author::class);
    // }
}
