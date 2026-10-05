<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Agrega el campo "role" a la tabla users.

    Se crea en una migración aparte (igual que la clase lo hizo con
    "add_cover_columns_to_movies_table") para diferenciar a los
    administradores del sitio de los usuarios comunes. El middleware
    "admin" verifica este valor para proteger el panel de administración.
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('cliente')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
