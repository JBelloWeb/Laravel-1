<x-layouts.admin>
    <x-slot:title>Eliminar entrada</x-slot:title>

    <header>
        <h1 class="font-display text-3xl font-bold">Eliminar entrada</h1>
        <p class="mt-1 text-tinta-suave">Esta acción no se puede deshacer.</p>
    </header>

    <article class="mt-6 max-w-2xl rounded-xl border border-red-200 bg-white p-6">
        <h2 class="font-display text-xl font-semibold">{{ $post->title }}</h2>
        <p class="mt-2 text-tinta-suave">{{ $post->summary }}</p>

        <div class="mt-6 flex flex-wrap gap-4">
            <form action="{{ route('admin.posts.destroy', ['id' => $post->post_id]) }}" method="post">
                @csrf
                <button
                    type="submit"
                    class="rounded bg-red-700 px-5 py-2 font-semibold text-white transition hover:bg-red-800"
                >
                    Sí, eliminar
                </button>
            </form>

            <a
                href="{{ route('admin.posts.index') }}"
                class="rounded border border-tinta/30 px-5 py-2 font-semibold transition hover:border-arcilla hover:text-arcilla"
            >
                Cancelar
            </a>
        </div>
    </article>
</x-layouts.admin>
