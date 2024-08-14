<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Models\Book;
use App\Models\Author;

class Publisher extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name', 'address', 'website', 'email', 'phone', 'established_year',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }


    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
