<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Post;
use App\Models\Review;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Panel de administración: estadísticas del sitio.
     */
    public function index(): View
    {
        $stats = [
            'posts' => Post::count(),
            'publishedPosts' => Post::where('published', true)->count(),
            'books' => Book::count(),
            'reviews' => Review::count(),
        ];

        return view('admin.home', compact('stats'));
    }
}
