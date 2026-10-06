<x-layouts.main>
    <x-slot:title>{{ $book->title }}</x-slot:title>
    <x-slot name="description">{{ mb_substr($book->synopsis, 0, 155) }}</x-slot>

    <nav aria-label="Migas de pan" class="text-sm text-tinta-suave">
        <ol class="flex flex-wrap gap-2">
            <li><a href="{{ route('index') }}" class="hover-linea">Inicio</a></li>
            <li aria-hidden="true">›</li>
            <li><a href="{{ route('books.index') }}" class="hover-linea">Libros</a></li>
            <li aria-hidden="true">›</li>
            <li aria-current="page" class="font-medium text-tinta">{{ $book->title }}</li>
        </ol>
    </nav>

    <article class="mt-6 grid gap-8 md:grid-cols-[240px_1fr]">
        <div class="book-cover mx-auto w-56 md:w-full" aria-hidden="true">
            {{ mb_strtoupper(mb_substr($book->title, 0, 1)) }}
        </div>

        <div>
            <header>
                <p class="text-sm text-tinta-suave">
                    {{ $book->publisher?->name ?? 'Sin editorial' }}
                </p>
                <h1 class="mt-1 font-display text-3xl font-bold">{{ $book->title }}</h1>
                <p class="mt-1 text-lg text-tinta-suave">de {{ $book->author }}</p>
            </header>

            <dl class="mt-6 grid max-w-md grid-cols-[auto_1fr] gap-x-6 gap-y-2 text-sm">
                <dt class="font-semibold">ISBN</dt>
                <dd>{{ $book->isbn ?? '—' }}</dd>

                <dt class="font-semibold">Precio</dt>
                <dd class="text-lg font-bold text-arcilla">${{ number_format($book->price, 2, ',', '.') }}</dd>

                <dt class="font-semibold">Disponibilidad</dt>
                <dd>
                    @if ($book->stock > 0)
                        <span class="text-green-700">En stock ({{ $book->stock }} unidades)</span>
                    @else
                        <span class="text-red-700">Sin stock</span>
                    @endif
                </dd>

                <dt class="font-semibold">Valoración</dt>
                <dd>
                    @if ($ratingAvg !== null)
                        {{ number_format($ratingAvg, 1) }} / 5
                        <span class="text-tinta-suave">({{ $reviews->total() }} reseñas)</span>
                    @else
                        Todavía sin reseñas
                    @endif
                </dd>
            </dl>

            <section aria-labelledby="sinopsis-titulo" class="mt-6">
                <h2 id="sinopsis-titulo" class="font-display text-xl font-semibold">Sinopsis</h2>
                <div class="texto-largo mt-2 text-tinta-suave">
                    <p>{{ $book->synopsis }}</p>
                </div>
            </section>
        </div>
    </article>

    <section aria-labelledby="resenas-titulo" class="mt-12 border-t border-tinta/10 pt-8">
        <h2 id="resenas-titulo" class="font-display text-2xl font-semibold">Reseñas de lectores</h2>

        @auth
            <form
                action="{{ route('reviews.store', ['id' => $book->book_id]) }}"
                method="post"
                class="mt-6 border border-tinta/20 p-5"
            >
                @csrf

                @if ($errors->any())
                    <div class="mb-4 border-l-4 border-red-700 bg-red-50 px-4 py-3 text-sm text-red-900" role="alert">
                        <p class="font-semibold">Revisá la reseña antes de enviarla:</p>
                <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                @endif

                <h3 class="font-semibold">Dejá tu reseña</h3>

                <div class="mt-4 max-w-xs">
                    <label for="rating" class="block text-sm font-semibold">Puntaje</label>
                    <select
                        id="rating"
                        name="rating"
                        @class(['mt-1 w-full border border-tinta/30 px-3 py-2', 'border-red-500' => $errors->has('rating')])
                        aria-describedby="error-rating"
                    >
                        <option value="">Elegí una puntuación</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected((string) old('rating') === (string) $i)>
                                {{ $i }} estrella{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <p id="error-rating" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="comment" class="block text-sm font-semibold">Comentario (opcional)</label>
                    <textarea
                        id="comment"
                        name="comment"
                        rows="3"
                        @class(['mt-1 w-full border border-tinta/30 px-3 py-2', 'border-red-500' => $errors->has('comment')])
                        aria-describedby="error-comment"
                    >{{ old('comment') }}</textarea>
                    @error('comment')
                        <p id="error-comment" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="btn-solido mt-4 px-5 py-2"
                >
                    Publicar reseña
                </button>
            </form>
        @else
            <p class="mt-4 border-l-4 border-tinta/40 bg-papel-hondo px-4 py-3 text-sm text-tinta-suave">
                <a href="{{ route('auth.login.form') }}" class="font-semibold text-arcilla hover-linea">Iniciá sesión</a>
                para dejar tu reseña.
            </p>
        @endauth

        <ul class="mt-6">
            @forelse ($reviews as $review)
                <li>
                    <article class="border-t border-tinta/20 py-4">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <p class="font-semibold">{{ $review->user?->name ?? 'Lector/a' }}</p>
                            <p class="text-sm font-bold text-arcilla" aria-label="Puntaje: {{ $review->rating }} de 5">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </p>
                        </div>
                        @if ($review->comment)
                            <p class="mt-2 text-tinta-suave">{{ $review->comment }}</p>
                        @endif
                        <p class="mt-2 text-xs text-tinta-suave">
                            <time datetime="{{ $review->created_at?->format('Y-m-d') }}">
                                {{ $review->created_at?->format('d/m/Y') }}
                            </time>
                        </p>
                    </article>
                </li>
            @empty
                <li class="text-tinta-suave">Nadie reseñó este libro todavía. ¡Sé el primero!</li>
            @endforelse
        </ul>
    </section>
</x-layouts.main>
