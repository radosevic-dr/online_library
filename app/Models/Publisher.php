<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Models\Book;
use App\Models\Author;

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

    // Relations in Book model
    // public function publisher()
    // {
    //     return $this->belongsTo(Publisher::class);
    // }

    // Relations in Author model
    // public function publishers()
    // {
    //     return $this->belongsToMany(Publisher::class);

    // }

    // public function books()
    // {
    //     return $this->hasMany(Book::class);
    // }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
