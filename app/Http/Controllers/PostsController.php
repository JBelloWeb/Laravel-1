<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostsController extends Controller
{
    /**
     * Listado público del blog (solo publicadas).
     */
    public function index(): View
    {
        $posts = Post::where('published', true)
            ->latest('published_at')
            ->paginate(9);

        return view('posts.index', compact('posts'));
    }

    /**
     * Entrada completa.
     */
    public function show(string $id): View
    {
        $post = Post::findOrFail($id);

        // Los borradores no se ven: 404 para el público en general,
        // pero el admin del panel puede previsualizar (botón "Ver").
        $esAdmin = Auth::check() && Auth::user()->role === 'admin';
        abort_unless($post->published || $esAdmin, 404);

        return view('posts.show', compact('post'));
    }
}
