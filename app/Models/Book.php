<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    
    const SCRIPTS = [
        'cyrilic',
        'latin',
        'arabic',
    ];

    const LANGUAGES = [
        'english',
        'french',
        'spanish',
        'german',
        'russian',
    ];

    const BINDINGS = [
        'hardcover',
        'paperback',
        'spiral-bound',
    ];

    const DIMENSIONS = [
        'A1',
        'A2',
        'A3',
        'A4',
        'A5',
        'A6',
    ];

    protected $fillable = [
        'name',
        'description',
        'pages',
        'available_copies',
        'isbn',
        'language',
        'script',
        'binding',
        'dimensions',
    ];

    protected $casts = [
        'language' => 'string',
        'script' => 'string',
        'binding' => 'string',
        'dimensions' => 'string',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function publishers()
    {
        return $this->belongsToMany(Publisher::class);
    }

    public function images()
    {
        return $this->hasMany(\Spatie\Image\Image::class);
    }
}
