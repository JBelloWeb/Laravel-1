<x-layouts.main>
    <x-slot:title>{{ $post->title }}</x-slot:title>
    <x-slot name="description">{{ $post->summary }}</x-slot>

    <nav aria-label="Migas de pan" class="text-sm text-tinta-suave">
        <ol class="flex flex-wrap gap-2">
            <li><a href="{{ route('index') }}" class="hover:text-arcilla">Inicio</a></li>
            <li aria-hidden="true">›</li>
            <li><a href="{{ route('posts.index') }}" class="hover:text-arcilla">Blog</a></li>
            <li aria-hidden="true">›</li>
            <li aria-current="page" class="max-w-xs truncate font-medium text-tinta">{{ $post->title }}</li>
        </ol>
    </nav>

    <article class="mx-auto mt-6 max-w-3xl">
        <header>
            @if ($post->categories->isNotEmpty())
                <ul class="flex flex-wrap gap-2" aria-label="Categorías">
                    @foreach ($post->categories as $category)
                        <li class="rounded-full bg-papel-hondo px-3 py-1 text-xs font-semibold text-tinta-suave">
                            {{ $category->name }}
                        </li>
                    @endforeach
                </ul>
            @endif

            <h1 class="mt-3 font-display text-3xl font-bold leading-tight">{{ $post->title }}</h1>

            <p class="mt-3 text-sm text-tinta-suave">
                Por {{ $post->user?->name ?? 'Equipo Umbral' }}
                @if ($post->published_at)
                    ·
                    <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                        {{ $post->published_at->translatedFormat('d \d\e F \d\e Y') }}
                    </time>
                @endif
            </p>
        </header>

        @if ($post->cover)
            <img
                src="{{ asset('storage/' . $post->cover) }}"
                alt="Imagen de portada de la entrada {{ $post->title }}"
                class="mt-6 w-full rounded-xl"
                loading="lazy"
            >
        @endif

        <p class="mt-6 text-lg font-medium text-tinta-suave">{{ $post->summary }}</p>

        <div class="texto-largo mt-6 text-tinta">
            {!! nl2br(e($post->body)) !!}
        </div>
    </article>

    <footer class="mx-auto mt-10 max-w-3xl border-t border-tinta/10 pt-6">
        <a href="{{ route('posts.index') }}" class="font-semibold text-arcilla hover:underline">
            ← Volver al blog
        </a>
    </footer>
</x-layouts.main>
