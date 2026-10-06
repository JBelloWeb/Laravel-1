<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Reseñas: un usuario puntúa (1-5) y comenta un libro.
 *
 * PK propia: review_id. La BD garantiza un solo registro por
 * (book_id, user_id) con un índice unique.
 *
 * @mixin IdeHelperReview
 */
class Review extends Model
{
    use HasFactory;

    /** La tabla usa una clave primaria con nombre, no "id". */
    protected $primaryKey = 'review_id';

    /**
     * @var list<string>
     */
    protected $fillable = ['book_id', 'user_id', 'rating', 'comment'];

    /**
     * Relación: la reseña es sobre un libro (N:1).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Book, \App\Models\Review>
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    /**
     * Relación: la reseña la dejó un usuario (N:1).
     * En la vista: $review->user?->name (si se borró el usuario,
     * muestra "Lector/a").
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Review>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
