<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_invitado_no_puede_dejar_resena(): void
    {
        $libro = $this->crearLibro();

        $this->post(route('reviews.store', ['id' => $libro->book_id]), [
            'rating' => 5,
        ])->assertRedirect(route('auth.login.form'));

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_el_puntaje_es_obligatorio(): void
    {
        $libro = $this->crearLibro();

        $this->actingAs($this->lector())
            ->from(route('books.show', ['id' => $libro->book_id]))
            ->post(route('reviews.store', ['id' => $libro->book_id]), [
                'comment' => 'Se me olvidó el puntaje.',
            ])
            ->assertSessionHasErrors('rating');

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_el_puntaje_tiene_que_estar_entre_1_y_5(): void
    {
        $libro = $this->crearLibro();

        $this->actingAs($this->lector())
            ->post(route('reviews.store', ['id' => $libro->book_id]), [
                'rating' => 9,
            ])
            ->assertSessionHasErrors('rating');

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_una_primer_resena_se_crea(): void
    {
        $libro = $this->crearLibro();

        $this->actingAs($this->lector())
            ->post(route('reviews.store', ['id' => $libro->book_id]), [
                'rating' => 5,
                'comment' => 'Muy bueno.',
            ])
            ->assertRedirect(route('books.show', ['id' => $libro->book_id]))
            ->assertSessionHas('feedback.type', 'success');

        $this->assertDatabaseHas('reviews', [
            'book_id' => $libro->book_id,
            'rating' => 5,
        ]);
    }

    public function test_una_segunda_resena_actualiza_la_anterior_no_la_duplica(): void
    {
        $libro = $this->crearLibro();
        $lector = $this->lector();

        $this->actingAs($lector)->post(route('reviews.store', ['id' => $libro->book_id]), [
            'rating' => 3,
        ]);
        $this->actingAs($lector)->post(route('reviews.store', ['id' => $libro->book_id]), [
            'rating' => 4,
            'comment' => 'Cambié de opinión.',
        ]);

        // updateOrCreate: sigue habiendo UNA sola fila, con el puntaje nuevo.
        $this->assertDatabaseCount('reviews', 1);
        $this->assertDatabaseHas('reviews', [
            'book_id' => $libro->book_id,
            'user_id' => $lector->id,
            'rating' => 4,
        ]);
    }

    private function crearLibro(): Book
    {
        $editorial = Publisher::create(['name' => 'Editorial de prueba']);

        return Book::create([
            'title' => 'Libro para reseñar',
            'author' => 'Autor de prueba',
            'publisher_id' => $editorial->publisher_id,
            'price' => 1200,
            'synopsis' => 'Sinopsis de prueba.',
        ]);
    }

    private function lector(): User
    {
        return User::create([
            'name' => 'Lector',
            'email' => 'lector@correo.test',
            'password' => 'password',
            'role' => 'cliente',
        ]);
    }
}
