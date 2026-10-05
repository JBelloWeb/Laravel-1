<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Todas las entradas quedan publicadas con autor = user_id 1 (el admin).
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'post_id' => 1,
                'title' => 'Novedades de octubre: los lanzamientos que no te podés perder',
                'summary' => 'Selección de novedades editoriales del mes, desde ficción argentina hasta ciencia ficción clásica.',
                'body' => "Octubre trae una tanda de lanzamientos imperdibles. Entre las novedades destacamos una nueva edición ilustrada de Cien años de soledad, la reedición de Los siete locos con prólogo inédito y la llegada de la traducción al castellano de un clásico de la ciencia ficción.\n\nComo siempre, todos los títulos están disponibles en el mostrador y también en nuestra tienda online con envío a todo el país.",
                'cover' => null,
                'published' => true,
                'published_at' => '2026-10-01',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2,
                'title' => 'Reseña: El nombre del viento, la fantasía que engancha desde la primera página',
                'summary' => 'Leímos el inicio de la saga de Kvothe y contamos qué funciona y qué no en esta moderna obra de fantasía.',
                'body' => "Patrick Rothfuss construye un protagonista carismático y un mundo con reglas propias. La estructura de relato dentro del relato hace que las páginas pasen volando.\n\nSi te gusta la fantasía con humor, música y magia bien explicada, esta es tu próxima lectura. Ya está disponible en nuestra sección de destacados.",
                'cover' => null,
                'published' => true,
                'published_at' => '2026-09-28',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 3,
                'title' => 'Cómo armamos nuestro recomendador de lecturas',
                'summary' => 'Detrás de escena: las preguntas que usamos para sugerirte el libro perfecto según tu estado de ánimo.',
                'body' => "¿Buscás algo para viajar, para pensar o para desconectar? Armamos una guía simple basada en tres ejes: género, tiempo disponible y humor de lectura.\n\nProbalo en el mostrador o escribinos por la sección de contacto y te respondemos con tres sugerencias personalizadas.",
                'cover' => null,
                'published' => true,
                'published_at' => '2026-09-24',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 4,
                'title' => 'Entrevista: la edición independiente en Argentina hoy',
                'summary' => 'Hablamos con editores independientes sobre tirajes, distribución y el futuro del libro impreso.',
                'body' => "La edición independiente creció en los últimos años apostando a autores locales y diseños cuidados. Conversamos con tres proyectos de diferentes provincias sobre cómo sostenerse en un mercado competitivo.\n\nEl resultado: más variedad en las vitrinas y lectores con más opciones para descubrir.",
                'cover' => null,
                'published' => true,
                'published_at' => '2026-09-20',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 5,
                'title' => 'Guía para regalar libros en fechas clave',
                'summary' => 'Días del libro, fiestas, graduaciones: cómo elegir un libro acertado sin errarle al destinatario.',
                'body' => "Regalar libros es un acierto seguro si se tienen en cuenta tres cosas: los autores que ya lee, los temas que le despiertan curiosidad y el tiempo real que tiene para leer.\n\nSi no sabés por dónde empezar, nuestras tarjetas de regalo permiten que la persona elija sin presiones.",
                'cover' => null,
                'published' => true,
                'published_at' => '2026-09-15',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 6,
                'title' => 'Reseña: Cien años de soledad, la edición ilustrada que vale la coleccionar',
                'summary' => 'Analizamos la nueva edición ilustrada de la obra maestra de García Márquez: papel, ilustraciones y encuadernación.',
                'body' => "La nueva edición combina un diseño sobrio con ilustraciones a página completa que acompañan los momentos clave de la historia de los Buendía.\n\nPara quienes ya la leyeron, es una excusa para volver a Macondo; para los que aún no lo hicieron, no hay mejor momento.",
                'cover' => null,
                'published' => true,
                'published_at' => '2026-09-10',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 7,
                'title' => 'Feria del Libro: qué llevamos este año',
                'summary' => 'Nuestra participación en la Feria: stands, firmas, descuentos y actividades para toda la familia.',
                'body' => "Este año montamos un stand con más de 200 títulos, descuentos para socios y tres actividades diarias: clubes de lectura, cuentacuentos y conversatorios con autores.\n\nSeguinos en las redes para conocer el cronograma completo y las firmas programadas.",
                'cover' => null,
                'published' => true,
                'published_at' => '2026-09-05',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 8,
                'title' => '5 hábitos para leer más en el día a día',
                'summary' => 'Consejos prácticos para recuperar el hábito de la lectura en medio de la agenda ocupada.',
                'body' => "1. Dejá un libro a la vista, sobre la mesita de luz o el escritorio.\n2. Reemplazá diez minutos de scroll por diez minutos de lectura.\n3. Anotá dónde dejaste la última página: retomar es más fácil.\n4. Alterná géneros según tu energía del día.\n5. Unite a un club de lectura: la fecha de entrega ayuda a mantener el ritmo.",
                'cover' => null,
                'published' => true,
                'published_at' => '2026-09-01',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
