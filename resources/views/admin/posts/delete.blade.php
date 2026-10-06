<x-layouts.admin>
    <x-slot:title>Eliminar entrada</x-slot:title>

    <header>
        <h1 class="font-display text-3xl font-bold">Eliminar entrada</h1>
        <p class="mt-1 text-tinta-suave">Esta acción no se puede deshacer.</p>
    </header>

    <article class="mt-6 max-w-2xl border border-red-300 bg-white p-6">
        <h2 class="font-display text-xl font-semibold">{{ $post->title }}</h2>
        <p class="mt-2 text-tinta-suave">{{ $post->summary }}</p>

        <div class="mt-6 flex flex-wrap gap-4">
            <form action="{{ route('admin.posts.destroy', ['id' => $post->post_id]) }}" method="post">
                @csrf
                <button
                    type="submit"
                    class="btn-peligro px-5 py-2"
                >
                    Sí, eliminar
                </button>
            </form>

            <a
                href="{{ route('admin.posts.index') }}"
                class="btn-linea px-5 py-2"
            >
                Cancelar
            </a>
        </div>
    </article>
</x-layouts.admin>
