<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Crea o actualiza la reseña del usuario sobre un libro.
     */
    public function store(Request $request, string $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'Elegí una puntuación.',
            'rating.integer' => 'La puntuación tiene que ser un número entero.',
            'rating.min' => 'La puntuación mínima es 1 estrella.',
            'rating.max' => 'La puntuación máxima es 5 estrellas.',
            'comment.string' => 'El comentario tiene que ser texto.',
            'comment.max' => 'El comentario no puede superar los 1000 caracteres.',
        ]);

        // Si ya reseñó este libro, actualiza; si no, crea.
        Review::updateOrCreate(
            [
                'book_id' => $book->book_id,
                'user_id' => $request->user()->id,
            ],
            [
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ],
        );

        return redirect()->route('books.show', ['id' => $book->book_id])
            ->with('feedback.message', '¡Gracias! Tu reseña quedó guardada.')
            ->with('feedback.type', 'success');
    }
}
