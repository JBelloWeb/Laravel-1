<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Tabla pivote de la relación N:N entre categorías y posts.

    Un post puede tener varias categorías y una categoría puede agrupar
    muchos posts. La PK es compuesta por ambas columnas para evitar duplicados.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_post', function (Blueprint $table) {
            // Las PKs de categories y posts tienen nombre propio,
            // por eso se pasa la columna referenciada explícitamente.
            $table->foreignId('category_id')->constrained('categories', 'category_id')->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('posts', 'post_id')->cascadeOnDelete();

            $table->primary(['category_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_post');
    }
};
