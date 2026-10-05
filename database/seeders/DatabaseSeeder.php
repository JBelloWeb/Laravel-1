<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * El orden importa: primero las tablas "padre" (users, publishers,
     * categories) y después las que dependen de ellas mediante foreign keys.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PublisherSeeder::class,
            BookSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            CategoryPostSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
