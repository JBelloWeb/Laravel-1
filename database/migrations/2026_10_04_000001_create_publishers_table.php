<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Editoriales (1 a N con los libros).

    Relación: una editorial puede publicar muchos libros, y un libro pertenece
    a una sola editorial. Esta tabla es una "relación extra" respecto a los
    mínimos que pide la consigna.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publishers', function (Blueprint $table) {
            // PK con nombre propio, siguiendo la convención vista en clase
            // (en la semana-08 se usó $table->id('movie_id')).
            $table->id('publisher_id');

            $table->string('name', 100);
            $table->string('country', 60)->nullable();
            $table->string('website', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
