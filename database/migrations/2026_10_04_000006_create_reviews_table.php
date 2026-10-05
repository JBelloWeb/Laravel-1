<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Reseñas de los usuarios sobre los libros.

    Relación N:N entre users y books (un usuario reseña muchos libros y un
    libro recibe reseñas de muchos usuarios), resuelta con esta tabla propia.
    La restricción unique impide que un usuario reseñe dos veces el mismo libro.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');

            $table->foreignId('book_id')->constrained('books', 'book_id')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Puntaje del 1 al 5 (se valida en el controller).
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();

            $table->timestamps();

            $table->unique(['book_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
