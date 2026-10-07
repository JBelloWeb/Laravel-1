<x-layouts.admin>
    <x-slot:title>Entradas del blog</x-slot:title>

    <header class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold">Entradas del blog</h1>
            <p class="mt-1 text-tinta-suave">Alta, baja y modificación de novedades y noticias.</p>
        </div>
        <a
            href="{{ route('admin.posts.create') }}"
            class="btn-solido px-4 py-2"
        >
            Crear entrada
        </a>
    </header>

    @if ($posts->isEmpty())
        <div class="mt-8 border border-dashed border-tinta/30 p-8 text-center">
            <p class="text-tinta-suave">Todavía no hay entradas cargadas.</p>
            <a href="{{ route('admin.posts.create') }}" class="mt-3 inline-block font-semibold text-arcilla hover-linea">
                Crear la primera entrada →
            </a>
        </div>
    @else
        <div class="mt-8 overflow-x-auto border border-tinta/20 bg-white">
            <table class="w-full text-left text-sm">
                <caption class="sr-only">Listado de entradas del blog con sus acciones</caption>
                <thead class="border-b border-tinta/10 bg-papel-hondo text-xs font-semibold uppercase tracking-wide text-tinta-suave">
                    <tr>
                        <th scope="col" class="px-4 py-3">Título</th>
                        <th scope="col" class="px-4 py-3">Estado</th>
                        <th scope="col" class="px-4 py-3">Publicación</th>
                        <th scope="col" class="px-4 py-3">Categorías</th>
                        <th scope="col" class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tinta/10">
                    @foreach ($posts as $post)
                        <tr>
                            <th scope="row" class="px-4 py-3 font-semibold">
                                {{ $post->title }}
                            </th>
                            <td class="px-4 py-3">
                                @if ($post->published)
                                    <span class="bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-800">
                                        Publicada
                                    </span>
                                @else
                                    <span class="bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">
                                        Borrador
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                {{ $post->published_at?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($post->categories->isNotEmpty())
                                    {{ $post->categories->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-tinta-suave">Sin categoría</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-3">
                                    <a
                                        href="{{ route('posts.show', ['id' => $post->post_id]) }}"
                                        class="font-semibold text-arcilla hover-linea"
                                    >
                                        Ver
                                    </a>
                                    <a
                                        href="{{ route('admin.posts.edit', ['id' => $post->post_id]) }}"
                                        class="font-semibold text-blue-700 hover-linea"
                                    >
                                        Editar
                                    </a>
                                    <a
                                        href="{{ route('admin.posts.delete', ['id' => $post->post_id]) }}"
                                        class="font-semibold text-red-700 hover-linea"
                                    >
                                        Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav aria-label="Paginación de entradas" class="paginacion mt-6">
            {{ $posts->links() }}
        </nav>
    @endif
</x-layouts.admin>
