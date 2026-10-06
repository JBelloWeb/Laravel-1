<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Post;
use App\Models\Publisher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_portada_responde_ok(): void
    {
        $this->get(route('index'))->assertOk();
    }

    public function test_el_listado_de_libros_muestra_el_libro_creado(): void
    {
        $libro = $this->crearLibro('Libro de prueba');

        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee($libro->title);
    }

    public function test_la_ficha_de_un_libro_inexistente_responde_404(): void
    {
        $this->get(route('books.show', ['id' => 999]))->assertNotFound();
    }

    public function test_el_blog_solo_muestra_entradas_publicadas(): void
    {
        $this->crearEntrada('Entrada publicada', publicada: true);
        $this->crearEntrada('Entrada borrador', publicada: false);

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Entrada publicada')
            ->assertDontSee('Entrada borrador');
    }

    public function test_una_entrada_borrador_responde_404_para_visitantes(): void
    {
        $post = $this->crearEntrada('Borrador oculto', publicada: false);

        $this->get(route('posts.show', ['id' => $post->post_id]))
            ->assertNotFound();
    }

    public function test_una_entrada_publicada_se_muestra_completa(): void
    {
        $post = $this->crearEntrada('Noticia del dia', publicada: true);

        $this->get(route('posts.show', ['id' => $post->post_id]))
            ->assertOk()
            ->assertSee('Noticia del dia')
            ->assertSee('Cuerpo de la entrada de prueba.');
    }

    /**
     * Los libros necesitan editorial (publisher_id no es anulable).
     */
    private function crearLibro(string $titulo): Book
    {
        $editorial = Publisher::create(['name' => 'Editorial de prueba']);

        return Book::create([
            'title' => $titulo,
            'author' => 'Autor de prueba',
            'publisher_id' => $editorial->publisher_id,
            'price' => 1500,               // en pesos; el accessor guarda centavos
            'synopsis' => 'Sinopsis de prueba.',
        ]);
    }

    private function crearEntrada(string $titulo, bool $publicada): Post
    {
        return Post::create([
            'title' => $titulo,
            'summary' => 'Resumen de prueba.',
            'body' => 'Cuerpo de la entrada de prueba.',
            'published' => $publicada,
            'published_at' => $publicada ? now()->toDateString() : null,
        ]);
    }
}
