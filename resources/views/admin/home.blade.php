<x-layouts.admin>
    <x-slot:title>Dashboard</x-slot:title>

    <header class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold">Dashboard</h1>
            <p class="mt-1 text-tinta-suave">Resumen general del sitio.</p>
        </div>
        <a
            href="{{ route('admin.posts.create') }}"
            class="btn-solido px-4 py-2"
        >
            Crear entrada
        </a>
    </header>

    <ul class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <li class="border-t-2 border-tinta pt-3">
            <p class="text-sm font-semibold text-tinta-suave">Entradas totales</p>
            <p class="mt-1 font-display text-3xl font-bold">{{ $stats['posts'] }}</p>
        </li>
        <li class="border-t-2 border-tinta pt-3">
            <p class="text-sm font-semibold text-tinta-suave">Entradas publicadas</p>
            <p class="mt-1 font-display text-3xl font-bold text-green-700">{{ $stats['publishedPosts'] }}</p>
        </li>
        <li class="border-t-2 border-tinta pt-3">
            <p class="text-sm font-semibold text-tinta-suave">Libros en catálogo</p>
            <p class="mt-1 font-display text-3xl font-bold">{{ $stats['books'] }}</p>
        </li>
        <li class="border-t-2 border-tinta pt-3">
            <p class="text-sm font-semibold text-tinta-suave">Reseñas de lectores</p>
            <p class="mt-1 font-display text-3xl font-bold">{{ $stats['reviews'] }}</p>
        </li>
    </ul>

    <section aria-labelledby="acciones-titulo" class="mt-10">
        <h2 id="acciones-titulo" class="font-display text-xl font-semibold">Accesos rápidos</h2>
        <ul class="mt-4 flex flex-wrap gap-4 text-sm font-semibold">
            <li>
                <a href="{{ route('admin.posts.index') }}" class="btn-linea px-4 py-2">
                    Administrar entradas
                </a>
            </li>
            <li>
                <a href="{{ route('posts.index') }}" class="btn-linea px-4 py-2">
                    Ver el blog público
                </a>
            </li>
            <li>
                <a href="{{ route('books.index') }}" class="btn-linea px-4 py-2">
                    Ver el catálogo
                </a>
            </li>
        </ul>
    </section>
</x-layouts.admin>
