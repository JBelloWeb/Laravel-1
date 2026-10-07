<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    {{-- Presentación del producto / servicio --}}
    <section aria-labelledby="hero-titulo" class="border-y-2 border-tinta bg-papel-hondo px-6 py-14 text-center sm:px-12">
        <h1 id="hero-titulo" class="mx-auto max-w-3xl font-display text-4xl font-bold leading-tight sm:text-5xl">
            Libros elegidos con criterio, para lectores que disfrutan el camino
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg text-tinta-suave">
            En <strong>Librería Sempere</strong> seleccionamos títulos de literatura, ensayo y ciencia ficción,
            con recomendaciones personalizadas, reseñas honestas y envíos en 48 horas.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a
                href="{{ route('books.index') }}"
                class="btn-solido px-6 py-3"
            >
                Ver el catálogo
            </a>
            <a
                href="{{ route('posts.index') }}"
                class="btn-linea px-6 py-3"
            >
                Leer el blog
            </a>
        </div>
    </section>

    {{-- Beneficios del servicio --}}
    <section aria-labelledby="beneficios-titulo" class="mt-12">
        <h2 id="beneficios-titulo" class="font-display text-2xl font-semibold">¿Por qué comprar en Sempere?</h2>
        <ul class="mt-6 grid gap-6 sm:grid-cols-3">
            <li class="border-t-2 border-tinta pt-4">
                <h3 class="font-semibold">Curaduría humana</h3>
                <p class="mt-2 text-sm text-tinta-suave">
                    Cada título del catálogo fue leído y recomendado por nuestro equipo. Nada de algoritmos.
                </p>
            </li>
            <li class="border-t-2 border-tinta pt-4">
                <h3 class="font-semibold">Envíos en 48 horas</h3>
                <p class="mt-2 text-sm text-tinta-suave">
                    Despachamos el mismo día para pedidos antes de las 15 hs. Retiro gratuito en el local.
                </p>
            </li>
            <li class="border-t-2 border-tinta pt-4">
                <h3 class="font-semibold">Club de lectura mensual</h3>
                <p class="mt-2 text-sm text-tinta-suave">
                    Un título sorpresa por mes, encuentro virtual con autores y descuentos exclusivos.
                </p>
            </li>
        </ul>
    </section>

    {{-- Libros destacados --}}
    <section aria-labelledby="destacados-titulo" class="mt-12">
        <div class="flex flex-wrap items-baseline justify-between gap-2">
            <h2 id="destacados-titulo" class="font-display text-2xl font-semibold">Destacados de la semana</h2>
            <a href="{{ route('books.index') }}" class="text-sm font-semibold text-arcilla hover-linea">
                Ver todos los libros →
            </a>
        </div>

        <ul class="mt-6 grid border-t border-tinta/15 sm:grid-cols-2 sm:gap-x-10">
            @forelse ($featuredBooks as $book)
                <li class="border-b border-tinta/15">
                    <a
                        href="{{ route('books.show', ['id' => $book->book_id]) }}"
                        class="tarjeta-libro group flex items-center gap-4 px-1 py-4 sm:gap-5"
                    >
                        <div class="book-cover book-cover--mini shrink-0" aria-hidden="true">
                            {{ mb_strtoupper(mb_substr($book->title, 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="font-display text-base font-semibold leading-snug sm:text-lg">
                                <span class="hover-linea">{{ $book->title }}</span>
                            </h3>
                            <p class="mt-1 text-sm text-tinta-suave">{{ $book->author }}</p>
                            <p class="mt-1 text-sm font-semibold">${{ number_format($book->price, 2, ',', '.') }}</p>
                        </div>

                        <span aria-hidden="true" class="text-arcilla transition-transform duration-200 group-hover:translate-x-1">→</span>
                    </a>
                </li>
            @empty
                <li class="text-tinta-suave">Todavía no hay libros destacados.</li>
            @endforelse
        </ul>
    </section>

    {{-- Últimas novedades del blog --}}
    <section aria-labelledby="novedades-titulo" class="mt-12">
        <div class="flex flex-wrap items-baseline justify-between gap-2">
            <h2 id="novedades-titulo" class="font-display text-2xl font-semibold">Últimas novedades</h2>
            <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-arcilla hover-linea">
                Ir al blog →
            </a>
        </div>

        <ul class="mt-6 grid gap-6 md:grid-cols-3">
            @forelse ($latestPosts as $post)
                <li>
                    <article class="h-full border-t-2 border-tinta pt-4">
                        <p class="text-xs text-tinta-suave">
                            {{ $post->published_at?->format('d/m/Y') ?? $post->created_at?->format('d/m/Y') }}
                        </p>
                        <h3 class="mt-1 font-display text-lg font-semibold">
                            <a href="{{ route('posts.show', ['id' => $post->post_id]) }}" class="hover-linea">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-tinta-suave">{{ $post->summary }}</p>
                    </article>
                </li>
            @empty
                <li class="text-tinta-suave">Todavía no hay entradas publicadas.</li>
            @endforelse
        </ul>
    </section>
</x-layouts.main>
