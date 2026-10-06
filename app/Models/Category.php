<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Categorías del blog (N:N con posts vía category_post).
 *
 * PK propia: category_id.
 *
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    use HasFactory;

    /** La tabla usa una clave primaria con nombre, no "id". */
    protected $primaryKey = 'category_id';

    /**
     * @var list<string>
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Relación N:N inversa: una categoría agrupa muchas entradas.
     * Acá la columna del pivote que apunta a category es
     * "category_id" y la que apunta al otro lado es "post_id".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Post, \App\Models\Category>
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            'category_post',
            'category_id',
            'post_id',
        );
    }
}
