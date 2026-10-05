<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Reseñas de los usuarios comunes (user_id 2 y 3) sobre distintos libros.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'review_id' => 1,
                'book_id' => 1,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Me lo leí en tres días. Kvothe es de los protagonistas que no se olvidan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 2,
                'book_id' => 2,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'Muy entretenido. La Barcelona descrita es un personaje más.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 3,
                'book_id' => 3,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Obra imprescindible. La relectura siempre descubre algo nuevo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 4,
                'book_id' => 4,
                'user_id' => 3,
                'rating' => 5,
                'comment' => 'Leerlo saltando capítulos fue una experiencia única, muy recomendable.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 5,
                'book_id' => 5,
                'user_id' => 3,
                'rating' => 5,
                'comment' => 'Cada cuento es un mundo. Ideal para leer uno por noche.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 6,
                'book_id' => 6,
                'user_id' => 3,
                'rating' => 4,
                'comment' => 'Complejo pero fascinante. La edición de Anagrama es muy cuidada.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 7,
                'book_id' => 7,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Benedetti en estado puro: tierno, gracioso y triste a la vez.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 8,
                'book_id' => 9,
                'user_id' => 3,
                'rating' => 4,
                'comment' => 'El ritmo de la fuga no afloja en ningún momento.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 9,
                'book_id' => 10,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'Duro y brillante. La voz de los alumnos es demoledora.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'review_id' => 10,
                'book_id' => 12,
                'user_id' => 3,
                'rating' => 5,
                'comment' => 'La mejor novela de ciencia ficción que leí este año.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
