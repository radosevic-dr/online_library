<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('pages');
            $table->unsignedInteger('copies');
            $table->string('isbn');
            $table->enum('language', array_keys(Book::LANGUAGES))->index();
            $table->enum('script', array_keys(Book::SCRIPTS))->index();
            $table->enum('binding', array_keys(Book::BINDINGS))->index();
            $table->enum('dimensions', array_keys(Book::DIMENSIONS))->index();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');

    }
};
