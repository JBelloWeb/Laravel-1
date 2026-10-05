<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Libros: el producto a la venta de la librería.

    La consigna exige al menos 5 campos (sin contar PK ni fechas de Laravel):
    title, author, publisher_id, isbn, price, synopsis, stock, cover, featured.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');

            $table->string('title', 150);
            $table->string('author', 100);
            // constrained() recibe la tabla y la columna PK referenciada
            // (publishers usa una PK con nombre propio: publisher_id).
            $table->foreignId('publisher_id')->constrained('publishers', 'publisher_id')->restrictOnDelete();

            // ISBN de 13 dígitos. Queda nullable porque no todo libro tiene ISBN cargado.
            $table->string('isbn', 13)->unique()->nullable();

            // Precio en centavos (misma convención de la clase: se divide por 100
            // al leer mediante un accessor en el modelo).
            $table->unsignedInteger('price');

            $table->text('synopsis');
            $table->unsignedSmallInteger('stock')->default(0);

            // Ruta del archivo dentro del disco "public" (Storage).
            $table->string('cover')->nullable();

            // Indica si el libro se muestra destacado en la home.
            $table->boolean('featured')->default(false);

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
