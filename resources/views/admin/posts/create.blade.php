<x-layouts.admin>
    <x-slot:title>Crear entrada</x-slot:title>

    <header>
        <h1 class="font-display text-3xl font-bold">Crear entrada</h1>
        <p class="mt-1 text-tinta-suave">Nueva novedad o noticia para el blog.</p>
    </header>

    <form
        action="{{ route('admin.posts.store') }}"
        method="post"
        enctype="multipart/form-data"
        class="mt-6 max-w-3xl rounded-xl border border-tinta/10 bg-white p-6"
    >
        @csrf

        @include('admin.posts.partials.form', [
            'formAction' => route('admin.posts.store'),
            'categories' => $categories,
            'post' => null,
            'selectedCategoryIds' => [],
        ])
    </form>
</x-layouts.admin>
