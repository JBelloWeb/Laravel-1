<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('publishers')->insert([
            [
                'publisher_id' => 1,
                'name' => 'Planeta',
                'country' => 'España',
                'website' => 'https://www.grupoplaneta.es',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'publisher_id' => 2,
                'name' => 'Editorial Sudamericana',
                'country' => 'Argentina',
                'website' => 'https://www.penguinlibros.com/ar/sudamericana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'publisher_id' => 3,
                'name' => 'Anagrama',
                'country' => 'España',
                'website' => 'https://www.anagrama-ediciones.es',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'publisher_id' => 4,
                'name' => 'Emecé Editores',
                'country' => 'Argentina',
                'website' => 'https://www.emeceeditores.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'publisher_id' => 5,
                'name' => 'Alfaguara',
                'country' => 'España',
                'website' => 'https://www.alfaguara.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
