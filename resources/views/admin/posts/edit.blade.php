<x-layouts.admin>
    <x-slot:title>Editar entrada</x-slot:title>

    <header>
        <h1 class="font-display text-3xl font-bold">Editar entrada</h1>
        <p class="mt-1 text-tinta-suave">Modificando: {{ $post->title }}</p>
    </header>

    <form
        action="{{ route('admin.posts.update', ['id' => $post->post_id]) }}"
        method="post"
        enctype="multipart/form-data"
        class="mt-6 max-w-3xl border border-tinta/20 bg-white p-6"
    >
        @csrf

        @include('admin.posts.partials.form', [
            'formAction' => route('admin.posts.update', ['id' => $post->post_id]),
            'categories' => $categories,
            'post' => $post,
            'selectedCategoryIds' => $selectedCategoryIds,
        ])
    </form>
</x-layouts.admin>
