<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Entradas del blog / novedades / noticias.

    La consigna exige al menos 5 campos (sin contar PK ni fechas de Laravel):
    title, summary, body, cover, published, published_at, user_id.

    user_id es el autor de la entrada (relación N:1 con users).
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');

            $table->string('title', 150);
            $table->string('summary', 255);
            $table->text('body');

            // Ruta de la imagen de portada dentro del disco "public" (opcional).
            $table->string('cover')->nullable();

            // Permite publicar / despublicar una entrada desde el ABM.
            $table->boolean('published')->default(false);
            $table->date('published_at')->nullable();

            // Autor de la entrada. Debe ser nullable para que el
            // ON DELETE SET NULL (nullOnDelete) sea válido en MySQL.
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
