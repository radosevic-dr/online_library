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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('number_of_pages');
            $table->integer('quantity');
            $table->string('isbn');
            $table->string('language');
            $table->enum('script', ['latin', 'cyrilic', 'arabic']);
            $table->enum('binding', ['hardcover', 'paperback', 'spiral', 'stapled', 'saddle-stitched']);
            $table->enum('dimensions', ['A4', 'A5', '7.6 x 25 cm', '15.2 x 22.9 cm', '14 x 21.6 cm']);
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
