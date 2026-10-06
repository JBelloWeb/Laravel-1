<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Entradas del blog.
 *
 * PK propia: post_id. "published" es un interruptor (borrador /
 * publicada) y "published_at" la fecha que se muestra en el sitio.
 *
 * @mixin IdeHelperPost
 */
class Post extends Model
{
    use HasFactory;

    /** La tabla usa una clave primaria con nombre, no "id". */
    protected $primaryKey = 'post_id';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'summary',
        'body',
        'cover',
        'published',
        'published_at',
        'user_id',
    ];

    /**
     * Conversión de tipos.
     * - published como booleano real (true/false), no "0"/"1".
     * - published_at como fecha (Carbon): las vistas usan
     *   ->format('d/m/Y') y ->translatedFormat(...).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'published_at' => 'date',
        ];
    }

    /**
     * Relación: la entrada la escribió un usuario (N:1).
     * En la vista se usa como $post->user?->name (si el usuario
     * fue borrado, muestra "Equipo Sempere").
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Post>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación N:N: una entrada tiene muchas categorías y una
     * categoría tiene muchas entradas, resuelta en el pivote
     * category_post.
     *
     * Parámetros de belongsToMany(qué modelo, tabla pivote,
     * columna que apunta a ESTE modelo, columna que apunta al otro):
     *   Post -> category_post(post_id, category_id)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Category, \App\Models\Post>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'category_post',
            'post_id',
            'category_id',
        );
    }
}
