<x-layouts.admin>
    <x-slot:title>Dashboard</x-slot:title>

    <header class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold">Dashboard</h1>
            <p class="mt-1 text-tinta-suave">Resumen general del sitio.</p>
        </div>
        <a
            href="{{ route('admin.posts.create') }}"
            class="rounded bg-arcilla px-4 py-2 font-semibold text-papel transition hover:bg-arcilla-hondo"
        >
            Crear entrada
        </a>
    </header>

    <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <li class="rounded-xl border border-tinta/10 bg-white p-5">
            <p class="text-sm font-semibold text-tinta-suave">Entradas totales</p>
            <p class="mt-1 font-display text-3xl font-bold">{{ $stats['posts'] }}</p>
        </li>
        <li class="rounded-xl border border-tinta/10 bg-white p-5">
            <p class="text-sm font-semibold text-tinta-suave">Entradas publicadas</p>
            <p class="mt-1 font-display text-3xl font-bold text-green-700">{{ $stats['publishedPosts'] }}</p>
        </li>
        <li class="rounded-xl border border-tinta/10 bg-white p-5">
            <p class="text-sm font-semibold text-tinta-suave">Libros en catálogo</p>
            <p class="mt-1 font-display text-3xl font-bold">{{ $stats['books'] }}</p>
        </li>
        <li class="rounded-xl border border-tinta/10 bg-white p-5">
            <p class="text-sm font-semibold text-tinta-suave">Reseñas de lectores</p>
            <p class="mt-1 font-display text-3xl font-bold">{{ $stats['reviews'] }}</p>
        </li>
    </ul>

    <section aria-labelledby="acciones-titulo" class="mt-10">
        <h2 id="acciones-titulo" class="font-display text-xl font-semibold">Accesos rápidos</h2>
        <ul class="mt-4 flex flex-wrap gap-4 text-sm font-semibold">
            <li>
                <a href="{{ route('admin.posts.index') }}" class="rounded border border-tinta/30 px-4 py-2 transition hover:border-arcilla hover:text-arcilla">
                    Administrar entradas
                </a>
            </li>
            <li>
                <a href="{{ route('posts.index') }}" class="rounded border border-tinta/30 px-4 py-2 transition hover:border-arcilla hover:text-arcilla">
                    Ver el blog público
                </a>
            </li>
            <li>
                <a href="{{ route('books.index') }}" class="rounded border border-tinta/30 px-4 py-2 transition hover:border-arcilla hover:text-arcilla">
                    Ver el catálogo
                </a>
            </li>
        </ul>
    </section>
</x-layouts.admin>
