<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Cargamos un usuario administrador (para ingresar al panel /admin)
     * y dos usuarios comunes que dejan reseñas en los libros.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Juan Peralta Bello',
                'email' => 'admin@libreria.test',
                // Hash::make() crea el hash bcrypt de la contraseña.
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Lucía Fernández',
                'email' => 'lucia@correo.test',
                'password' => Hash::make('password'),
                'role' => 'cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Martín Gómez',
                'email' => 'martin@correo.test',
                'password' => Hash::make('password'),
                'role' => 'cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
