<x-layouts.main>
    <x-slot:title>Blog de novedades</x-slot:title>

    <header>
        <h1 class="font-display text-3xl font-bold">Blog de novedades</h1>
        <p class="mt-2 text-tinta-suave">
            Reseñas, entrevistas y todo lo que pasa en el mundo del libro.
        </p>
    </header>

    <ul class="mt-8 space-y-6">
        @forelse ($posts as $post)
            <li>
                <article class="rounded-xl border border-tinta/10 bg-white p-6">
                    <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-wide">
                        <time
                            datetime="{{ $post->published_at?->format('Y-m-d') ?? $post->created_at?->format('Y-m-d') }}"
                            class="text-arcilla"
                        >
                            {{ $post->published_at?->format('d/m/Y') ?? $post->created_at?->format('d/m/Y') }}
                        </time>

                        @if ($post->categories->isNotEmpty())
                            <ul class="flex flex-wrap gap-2" aria-label="Categorías">
                                @foreach ($post->categories as $category)
                                    <li class="rounded-full bg-papel-hondo px-2 py-0.5 normal-case tracking-normal text-tinta-suave">
                                        {{ $category->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <h2 class="mt-3 font-display text-2xl font-semibold">
                        <a href="{{ route('posts.show', ['id' => $post->post_id]) }}" class="hover:text-arcilla">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <p class="mt-2 text-tinta-suave">{{ $post->summary }}</p>

                    <a
                        href="{{ route('posts.show', ['id' => $post->post_id]) }}"
                        class="mt-4 inline-block text-sm font-semibold text-arcilla hover:underline"
                        aria-label="Leer «{{ $post->title }}»"
                    >
                        Leer más →
                    </a>
                </article>
            </li>
        @empty
            <li class="text-tinta-suave">Todavía no hay entradas publicadas.</li>
        @endforelse
    </ul>

    <nav aria-label="Paginación del blog" class="mt-8">
        {{ $posts->links() }}
    </nav>
</x-layouts.main>
