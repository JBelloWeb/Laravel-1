<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    {{-- Presentación del producto / servicio --}}
    <section aria-labelledby="hero-titulo" class="rounded-2xl bg-papel-hondo px-6 py-12 text-center sm:px-12">
        <p class="text-sm font-semibold uppercase tracking-widest text-arcilla">Librería · Club de lectura · Envíos a todo el país</p>
        <h1 id="hero-titulo" class="mx-auto mt-4 max-w-3xl font-display text-4xl font-bold leading-tight sm:text-5xl">
            Libros elegidos con criterio, para lectores que disfrutan el camino
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg text-tinta-suave">
            En <strong>Librería Umbral</strong> seleccionamos títulos de literatura, ensayo y ciencia ficción,
            con recomendaciones personalizadas, reseñas honestas y envíos en 48 horas.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a
                href="{{ route('books.index') }}"
                class="rounded bg-arcilla px-6 py-3 font-semibold text-papel transition hover:bg-arcilla-hondo"
            >
                Ver el catálogo
            </a>
            <a
                href="{{ route('posts.index') }}"
                class="rounded border border-tinta/30 px-6 py-3 font-semibold transition hover:border-arcilla hover:text-arcilla"
            >
                Leer el blog
            </a>
        </div>
    </section>

    {{-- Beneficios del servicio --}}
    <section aria-labelledby="beneficios-titulo" class="mt-12">
        <h2 id="beneficios-titulo" class="font-display text-2xl font-semibold">¿Por qué comprar en Umbral?</h2>
        <ul class="mt-6 grid gap-6 sm:grid-cols-3">
            <li class="rounded-xl border border-tinta/10 bg-white p-5">
                <h3 class="font-semibold">Curaduría humana</h3>
                <p class="mt-2 text-sm text-tinta-suave">
                    Cada título del catálogo fue leído y recomendado por nuestro equipo. Nada de algoritmos.
                </p>
            </li>
            <li class="rounded-xl border border-tinta/10 bg-white p-5">
                <h3 class="font-semibold">Envíos en 48 horas</h3>
                <p class="mt-2 text-sm text-tinta-suave">
                    Despachamos el mismo día para pedidos antes de las 15 hs. Retiro gratuito en el local.
                </p>
            </li>
            <li class="rounded-xl border border-tinta/10 bg-white p-5">
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
            <a href="{{ route('books.index') }}" class="text-sm font-semibold text-arcilla hover:underline">
                Ver todos los libros →
            </a>
        </div>

        <ul class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($featuredBooks as $book)
                <li>
                    <a
                        href="{{ route('books.show', ['id' => $book->book_id]) }}"
                        class="group block rounded-xl border border-tinta/10 bg-white p-4 transition hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="book-cover" aria-hidden="true">
                            {{ mb_strtoupper(mb_substr($book->title, 0, 1)) }}
                        </div>
                        <h3 class="mt-4 font-display text-lg font-semibold group-hover:text-arcilla">
                            {{ $book->title }}
                        </h3>
                        <p class="text-sm text-tinta-suave">{{ $book->author }}</p>
                        <p class="mt-2 font-semibold">${{ number_format($book->price, 2, ',', '.') }}</p>
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
            <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-arcilla hover:underline">
                Ir al blog →
            </a>
        </div>

        <ul class="mt-6 grid gap-6 md:grid-cols-3">
            @forelse ($latestPosts as $post)
                <li>
                    <article class="h-full rounded-xl border border-tinta/10 bg-white p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-arcilla">
                            {{ $post->published_at?->format('d/m/Y') ?? $post->created_at?->format('d/m/Y') }}
                        </p>
                        <h3 class="mt-2 font-display text-lg font-semibold">
                            <a href="{{ route('posts.show', ['id' => $post->post_id]) }}" class="hover:text-arcilla">
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
