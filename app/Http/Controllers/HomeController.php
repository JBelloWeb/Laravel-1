<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Portada del sitio: libros destacados + últimas novedades.
     */
    public function index(): View
    {
        $featuredBooks = Book::where('featured', true)->latest()->get();

        $latestPosts = Post::where('published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('welcome', compact('featuredBooks', 'latestPosts'));
    }
}
