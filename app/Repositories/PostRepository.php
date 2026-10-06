<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Implementación Eloquent del repositorio de entradas.
 * Toda la persistencia (consultas y pivote category_post) vive acá.
 */
class PostRepository implements PostRepositoryInterface
{
    public function paginate(int $porPagina = 10): LengthAwarePaginator
    {
        return Post::with('categories')
            ->latest()
            ->paginate($porPagina);
    }

    public function findOrFail(int $id): Post
    {
        return Post::with(['categories', 'user'])->findOrFail($id);
    }

    public function create(array $datos, array $categorias = []): Post
    {
        $post = Post::create($datos);
        $post->categories()->sync($categorias);

        return $post;
    }

    public function update(Post $post, array $datos, array $categorias = []): Post
    {
        $post->update($datos);
        $post->categories()->sync($categorias);

        return $post;
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }
}
