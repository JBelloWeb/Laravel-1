<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostsController extends Controller
{
    /**
     * El controller depende de la INTERFAZ, no de Eloquent.
     * El contenedor de Laravel inyecta PostRepository porque
     * está bindeado en AppServiceProvider.
     */
    public function __construct(
        private readonly PostRepositoryInterface $posts,
    ) {
    }

    /**
     * Reglas de validación del ABM (server-side, sin HTML).
     *
     * @return array<string, array<int, string>>
     */
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'summary' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,category_id'],
            'published' => ['boolean'],
        ];
    }

    /**
     * Mensajes de error en castellano.
     *
     * @return array<string, string>
     */
    private function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede superar los 150 caracteres.',
            'summary.required' => 'El resumen es obligatorio.',
            'summary.max' => 'El resumen no puede superar los 255 caracteres.',
            'body.required' => 'El cuerpo de la entrada es obligatorio.',
            'cover.image' => 'La portada tiene que ser una imagen (jpg, png, gif…).',
            'cover.max' => 'La portada pesa más de 2 MB.',
            'published_at.date' => 'La fecha de publicación no es válida.',
            'categories.array' => 'Las categorías vienen en un formato incorrecto.',
            'categories.*' => 'Elegiste una categoría que no existe.',
        ];
    }

    /**
     * Listado de entradas del panel.
     */
    public function index(): View
    {
        $posts = $this->posts->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Formulario de alta.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Guarda la entrada nueva.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules(), $this->messages());

        $data['published'] = $request->boolean('published');
        $data['user_id'] = $request->user()->id;
        $data['published_at'] = $data['published_at']
            ?? ($data['published'] ? now()->toDateString() : null);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        } else {
            unset($data['cover']);
        }

        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        // La persistencia (create + sync del pivote) la hace el repositorio.
        $this->posts->create($data, $categories);

        return redirect()->route('admin.posts.index')
            ->with('feedback.message', 'La entrada se creó correctamente.')
            ->with('feedback.type', 'success');
    }

    /**
     * Formulario de edición (con las categorías ya tildadas).
     */
    public function edit(string $id): View
    {
        $post = $this->posts->findOrFail($id);

        $categories = Category::orderBy('name')->get();
        $selectedCategoryIds = $post->categories()->pluck('category_id')->all();

        return view('admin.posts.edit', compact('post', 'categories', 'selectedCategoryIds'));
    }

    /**
     * Actualiza la entrada.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $post = $this->posts->findOrFail($id);

        $data = $request->validate($this->rules(), $this->messages());

        $data['published'] = $request->boolean('published');
        $data['published_at'] = $data['published_at']
            ?? ($post->published_at ?? ($data['published'] ? now()->toDateString() : null));

        if ($request->hasFile('cover')) {
            $nuevaRuta = $request->file('cover')->store('covers', 'public');

            if ($post->cover && Storage::disk('public')->exists($post->cover)) {
                Storage::disk('public')->delete($post->cover);
            }

            $data['cover'] = $nuevaRuta;
        } else {
            unset($data['cover']);
        }

        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $this->posts->update($post, $data, $categories);

        return redirect()->route('admin.posts.index')
            ->with('feedback.message', 'La entrada se actualizó correctamente.')
            ->with('feedback.type', 'success');
    }

    /**
     * Vista de confirmación (NO borra nada).
     */
    public function delete(string $id): View
    {
        $post = $this->posts->findOrFail($id);

        return view('admin.posts.delete', compact('post'));
    }

    /**
     * Borra de verdad: portada del disco + entrada de la BD.
     * El borrado de la fila lo hace el repositorio; la portada
     * es responsabilidad del controller (es un archivo, no un dato).
     */
    public function destroy(string $id): RedirectResponse
    {
        $post = $this->posts->findOrFail($id);

        if ($post->cover && Storage::disk('public')->exists($post->cover)) {
            Storage::disk('public')->delete($post->cover);
        }

        $this->posts->delete($post);

        return redirect()->route('admin.posts.index')
            ->with('feedback.message', 'La entrada se eliminó.')
            ->with('feedback.type', 'success');
    }
}
