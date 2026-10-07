<x-layouts.main>
    <x-slot:title>Catálogo de libros</x-slot:title>

    <header>
        <h1 class="font-display text-3xl font-bold">Catálogo de libros</h1>
        <p class="mt-2 text-tinta-suave">
            Todos nuestros títulos, con stock en tiempo real y envío en 48 horas.
        </p>
    </header>

    <ul class="mt-8 border-t border-tinta/15">
        @forelse ($books as $book)
            <li class="border-b border-tinta/15">
                <a
                    href="{{ route('books.show', ['id' => $book->book_id]) }}"
                    class="tarjeta-libro group flex flex-wrap items-center gap-x-4 gap-y-2 px-2 py-4 sm:flex-nowrap sm:gap-x-6"
                >
                    <div class="book-cover book-cover--mini shrink-0" aria-hidden="true">
                        {{ mb_strtoupper(mb_substr($book->title, 0, 1)) }}
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-[0.7rem] font-semibold uppercase tracking-wider text-tinta-suave">
                            {{ $book->publisher?->name ?? 'Sin editorial' }}
                        </p>
                        <h2 class="mt-1 font-display text-lg font-semibold leading-snug">
                            <span class="hover-linea">{{ $book->title }}</span>
                        </h2>
                        <p class="mt-1 text-sm text-tinta-suave">{{ $book->author }}</p>
                    </div>

                    <div class="ml-auto flex shrink-0 items-baseline gap-4 text-right sm:gap-8">
                        <div>
                            <p class="font-semibold">${{ number_format($book->price, 2, ',', '.') }}</p>
                            <p class="mt-0.5 text-xs @if ($book->stock > 0) text-green-700 @else text-red-700 @endif">
                                @if ($book->stock > 0)
                                    En stock ({{ $book->stock }})
                                @else
                                    Sin stock
                                @endif
                            </p>
                        </div>
                        <span aria-hidden="true" class="text-arcilla transition-transform duration-200 group-hover:translate-x-1">→</span>
                    </div>
                </a>
            </li>
        @empty
            <li class="py-6 text-tinta-suave">No hay libros cargados en el catálogo.</li>
        @endforelse
    </ul>

    {{-- Paginación de Laravel --}}
    <nav aria-label="Paginación del catálogo" class="paginacion mt-8">
        {{ $books->links() }}
    </nav>
</x-layouts.main>
