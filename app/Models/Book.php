<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Libros: el catálogo/producto de la librería.
 *
 * PK propia: book_id. El precio se guarda en CENTAVOS (entero)
 * y se convierte en pesos mediante el accessor price().
 *
 * @mixin IdeHelperBook
 */
class Book extends Model
{
    use HasFactory;

    /** La tabla usa una clave primaria con nombre, no "id". */
    protected $primaryKey = 'book_id';

    /**
     * Campos que se permiten en create()/update().
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'author',
        'publisher_id',
        'isbn',
        'price',
        'synopsis',
        'stock',
        'cover',
        'featured',
    ];

    /**
     * Relación: cada libro pertenece a una editorial (N:1).
     * Hay que pasar la columna FK porque no sigue la convención
     * (sería book_publisher_id, pero la migración usa publisher_id).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Publisher, \App\Models\Book>
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    /**
     * Relación: un libro recibe muchas reseñas (1:N).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Review, \App\Models\Book>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'book_id');
    }

    /**
     * Accessor/Mutator del precio.
     *
     * - Se guarda en centavos (189900) para evitar errores de
     *   coma flotante con la plata.
     * - Al leerlo lo devuelve en pesos (1899.00), que es lo que
     *   usan las vistas con number_format($book->price, 2, ...).
     * - Si alguien asigna 1899, lo guarda como 189900.
     *
     * @return Attribute<int, int|float>
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value): float => $value / 100,
            set: fn ($value): int => (int) round($value * 100),
        );
    }
}
