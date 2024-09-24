<?php

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
        Schema::create('book_genres', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
//            $table->unsignedBigInteger('book_id');
//            $table->unsignedBigInteger('genre_id');
//            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
//            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_genres');
    }
};
