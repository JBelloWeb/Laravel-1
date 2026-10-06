<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_alta_valida_crea_la_entrada_con_sus_categorias(): void
    {
        $admin = $this->admin();   // UNA sola vez: admin() crea el usuario
        $categoria = Category::create(['name' => 'Novedades', 'slug' => 'novedades']);

        $this->actingAs($admin)
            ->post(route('admin.posts.store'), [
                'title' => 'Entrada creada en test',
                'summary' => 'Resumen corto.',
                'body' => 'Un cuerpo largo para la entrada.',
                'published' => '1',
                'published_at' => now()->toDateString(),
                'categories' => [$categoria->category_id],
            ])
            ->assertRedirect(route('admin.posts.index'))
            ->assertSessionHas('feedback.type', 'success');

        $post = Post::where('title', 'Entrada creada en test')->firstOrFail();

        $this->assertDatabaseHas('posts', [
            'post_id' => $post->post_id,
            'published' => 1,
            'user_id' => $admin->id,
        ]);
        $this->assertDatabaseHas('category_post', [
            'post_id' => $post->post_id,
            'category_id' => $categoria->category_id,
        ]);
    }

    public function test_el_alta_sin_titulo_no_crea_nada_y_muestra_errores(): void
    {
        $this->actingAs($this->admin())
            ->from(route('admin.posts.create'))
            ->post(route('admin.posts.store'), [
                'summary' => 'Resumen sin título.',
                'body' => 'Cuerpo sin título.',
            ])
            ->assertRedirect(route('admin.posts.create'))
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_elegir_una_categoria_inexistente_es_un_error_de_validacion(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.posts.store'), [
                'title' => 'Entrada con categoría rara',
                'summary' => 'Resumen.',
                'body' => 'Cuerpo.',
                'categories' => [999],
            ])
            ->assertSessionHasErrors('categories.0');

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_la_edicion_actualiza_titulo_y_categorias(): void
    {
        $post = $this->crearEntrada();
        $categoria = Category::create(['name' => 'Reseñas', 'slug' => 'resenas']);

        $this->actingAs($this->admin())
            ->post(route('admin.posts.update', ['id' => $post->post_id]), [
                'title' => 'Titulo actualizado',
                'summary' => 'Resumen actualizado.',
                'body' => 'Cuerpo actualizado.',
                'published' => '1',
                'categories' => [$categoria->category_id],
            ])
            ->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('posts', [
            'post_id' => $post->post_id,
            'title' => 'Titulo actualizado',
        ]);
        $this->assertDatabaseHas('category_post', [
            'post_id' => $post->post_id,
            'category_id' => $categoria->category_id,
        ]);
    }

    public function test_eliminar_pide_confirmacion_y_despues_borra(): void
    {
        $post = $this->crearEntrada();
        $admin = $this->admin();   // UNA sola vez (no repetir: violaría el unique de email)

        // "delete" es solo la pantalla de confirmación: todavía no borra.
        $this->actingAs($admin)
            ->get(route('admin.posts.delete', ['id' => $post->post_id]))
            ->assertOk()
            ->assertSee($post->title);

        $this->assertDatabaseHas('posts', ['post_id' => $post->post_id]);

        // "destroy" es el POST que sí elimina.
        $this->actingAs($admin)
            ->post(route('admin.posts.destroy', ['id' => $post->post_id]))
            ->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseMissing('posts', ['post_id' => $post->post_id]);
    }

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@correo.test',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }

    private function crearEntrada(): Post
    {
        return Post::create([
            'title' => 'Entrada de prueba',
            'summary' => 'Resumen de prueba.',
            'body' => 'Cuerpo de prueba.',
            'published' => true,
            'published_at' => now()->toDateString(),
        ]);
    }
}
