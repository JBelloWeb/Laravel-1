<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Contrato del repositorio de entradas del blog.
 *
 * El controller depende de ESTA interfaz, no de Eloquent.
 * La implementación concreta (PostRepository) la resuelve
 * el contenedor de servicios en AppServiceProvider.
 */
interface PostRepositoryInterface
{
    /**
     * Listado paginado con las categorías ya cargadas.
     */
    public function paginate(int $porPagina = 10): LengthAwarePaginator;

    /**
     * Busca una entrada por id o lanza 404 (findOrFail).
     */
    public function findOrFail(int $id): Post;

    /**
     * Crea la entrada y sincroniza sus categorías.
     *
     * @param  array<string, mixed>  $datos
     * @param  array<int, int>  $categorias  ids de categorías elegidas
     */
    public function create(array $datos, array $categorias = []): Post;

    /**
     * Actualiza la entrada y re-sincroniza sus categorías.
     *
     * @param  array<string, mixed>  $datos
     * @param  array<int, int>  $categorias
     */
    public function update(Post $post, array $datos, array $categorias = []): Post;

    /**
     * Elimina la entrada.
     */
    public function delete(Post $post): void;
}
