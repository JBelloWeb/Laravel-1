<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;

class BooksController extends Controller
{
    /**
     * Listado público del catálogo (paginado).
     */
    public function index(): View
    {
        $books = Book::latest()
            ->paginate(12);

        return view('libros.index', compact('books'));
    }

    /**
     * Ficha de un libro: datos, reseñas y valoración promedio.
     */
    public function show(string $id): View
    {
        // findOrFail → 404 si el id no existe.
        $book = Book::findOrFail($id);

        // Reseñas, más nuevas primero, paginadas.
        $reviews = $book->reviews()
            ->latest()
            ->paginate(10);

        // Promedio de estrellas (null si nadie reseñó: la vista
        // lo detecta con $ratingAvg !== null).
        $ratingAvg = $book->reviews()->avg('rating');

        return view('libros.show', compact('book', 'reviews', 'ratingAvg'));
    }
}
