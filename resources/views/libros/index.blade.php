<x-layouts.main>
    <x-slot:title>Catálogo de libros</x-slot:title>

    <header>
        <h1 class="font-display text-3xl font-bold">Catálogo de libros</h1>
        <p class="mt-2 text-tinta-suave">
            Todos nuestros títulos, con stock en tiempo real y envío en 48 horas.
        </p>
    </header>

    <ul class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($books as $book)
            <li>
                <article class="flex h-full flex-col border border-tinta/20 p-5">
                    <a
                        href="{{ route('books.show', ['id' => $book->book_id]) }}"
                        class="group"
                        aria-label="Ver detalle de {{ $book->title }}"
                    >
                        <div class="book-cover" aria-hidden="true">
                            {{ mb_strtoupper(mb_substr($book->title, 0, 1)) }}
                        </div>
                    </a>

                    <div class="mt-4 flex flex-1 flex-col">
                        <p class="text-xs text-tinta-suave">
                            {{ $book->publisher?->name ?? 'Sin editorial' }}
                        </p>
                        <h2 class="mt-1 font-display text-xl font-semibold">
                            <a href="{{ route('books.show', ['id' => $book->book_id]) }}" class="hover-linea">
                                {{ $book->title }}
                            </a>
                        </h2>
                        <p class="text-sm text-tinta-suave">{{ $book->author }}</p>

                        <p class="mt-3 text-lg font-semibold">${{ number_format($book->price, 2, ',', '.') }}</p>

                        <p class="mt-auto pt-3 text-sm">
                            @if ($book->stock > 0)
                                <span class="text-green-700">En stock ({{ $book->stock }} disponibles)</span>
                            @else
                                <span class="text-red-700">Sin stock</span>
                            @endif
                        </p>

                        <a
                            href="{{ route('books.show', ['id' => $book->book_id]) }}"
                            class="btn-linea mt-4 px-4 py-2 text-center text-sm"
                        >
                            Ver detalle
                        </a>
                    </div>
                </article>
            </li>
        @empty
            <li class="text-tinta-suave">No hay libros cargados en el catálogo.</li>
        @endforelse
    </ul>

    {{-- Paginación de Laravel --}}
    <nav aria-label="Paginación del catálogo" class="mt-8">
        {{ $books->links() }}
    </nav>
</x-layouts.main>
