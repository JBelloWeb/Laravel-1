<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Editoriales de los libros (1:N con books).
 *
 * PK propia: publisher_id.
 *
 * @mixin IdeHelperPublisher
 */
class Publisher extends Model
{
    use HasFactory;

    /** La tabla usa una clave primaria con nombre, no "id". */
    protected $primaryKey = 'publisher_id';

    /**
     * @var list<string>
     */
    protected $fillable = ['name', 'country', 'website'];

    /**
     * Relación: una editorial publica muchos libros (1:N).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Book, \App\Models\Publisher>
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'publisher_id');
    }
}
