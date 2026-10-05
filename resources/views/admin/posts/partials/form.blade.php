{{--
    Campos compartidos del formulario ABM de entradas.
    Lo usan: admin/posts/create.blade.php y admin/posts/edit.blade.php.

    Variables que recibe:
        $formAction          => URL (route) a la que se envía el formulario
        $categories          => colección de todas las categorías
        $post                => entrada a editar o null (alta)
        $selectedCategoryIds => ids de categorías marcadas (en edición)
--}}
@php
    $post = $post ?? null;
    $selectedCategoryIds = $selectedCategoryIds ?? [];
    $editing = $post !== null;
@endphp

@if ($errors->any())
    <div class="mb-6 rounded border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-900" role="alert">
        <p class="font-semibold">Los datos enviados tienen errores:</p>
        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="title" class="block text-sm font-semibold">Título</label>
    <input
        type="text"
        id="title"
        name="title"
        maxlength="150"
        value="{{ old('title', $post?->title) }}"
        @class(['mt-1 w-full rounded border border-tinta/30 px-3 py-2', 'border-red-500' => $errors->has('title')])
        aria-describedby="error-title"
    >
    @error('title')
        <p id="error-title" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
    @enderror
</div>

<div class="mt-4">
    <label for="summary" class="block text-sm font-semibold">Resumen</label>
    <textarea
        id="summary"
        name="summary"
        rows="2"
        maxlength="255"
        @class(['mt-1 w-full rounded border border-tinta/30 px-3 py-2', 'border-red-500' => $errors->has('summary')])
        aria-describedby="error-summary help-summary"
    >{{ old('summary', $post?->summary) }}</textarea>
    <p id="help-summary" class="mt-1 text-xs text-tinta-suave">Se muestra en el listado del blog (máx. 255 caracteres).</p>
    @error('summary')
        <p id="error-summary" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
    @enderror
</div>

<div class="mt-4">
    <label for="body" class="block text-sm font-semibold">Cuerpo de la entrada</label>
    <textarea
        id="body"
        name="body"
        rows="10"
        @class(['mt-1 w-full rounded border border-tinta/30 px-3 py-2', 'border-red-500' => $errors->has('body')])
        aria-describedby="error-body help-body"
    >{{ old('body', $post?->body) }}</textarea>
    <p id="help-body" class="mt-1 text-xs text-tinta-suave">Separá los párrafos con una línea en blanco.</p>
    @error('body')
        <p id="error-body" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
    @enderror
</div>

<div class="mt-4 grid gap-4 sm:grid-cols-2">
    <div>
        <label for="published_at" class="block text-sm font-semibold">Fecha de publicación</label>
        <input
            type="date"
            id="published_at"
            name="published_at"
            value="{{ old('published_at', $post?->published_at?->format('Y-m-d')) }}"
            @class(['mt-1 w-full rounded border border-tinta/30 px-3 py-2', 'border-red-500' => $errors->has('published_at')])
            aria-describedby="error-published_at"
        >
        @error('published_at')
            <p id="error-published_at" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="cover" class="block text-sm font-semibold">Imagen de portada (opcional)</label>
        <input
            type="file"
            id="cover"
            name="cover"
            accept="image/*"
            @class(['mt-1 w-full rounded border border-tinta/30 px-3 py-2', 'border-red-500' => $errors->has('cover')])
            aria-describedby="error-cover"
        >
        @if ($editing && $post?->cover)
            <p class="mt-1 text-xs text-tinta-suave">
                Imagen actual:
                <img src="{{ asset('storage/' . $post->cover) }}" alt="Portada actual de la entrada" class="mt-1 h-16 w-12 rounded object-cover">
            </p>
        @endif
        @error('cover')
            <p id="error-cover" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
        @enderror
    </div>
</div>

<fieldset class="mt-4">
    <legend class="text-sm font-semibold">Categorías</legend>
    <div class="mt-2 flex flex-wrap gap-4">
        @foreach ($categories as $category)
            <label class="flex items-center gap-2 text-sm">
                <input
                    type="checkbox"
                    name="categories[]"
                    value="{{ $category->category_id }}"
                    @checked(in_array(
                        (string) $category->category_id,
                        array_map('strval', old('categories', $selectedCategoryIds))
                    ))
                >
                {{ $category->name }}
            </label>
        @endforeach
    </div>
    @error('categories')
        <p class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
    @enderror
</fieldset>

<label class="mt-4 flex items-center gap-2 text-sm font-semibold">
    <input type="checkbox" name="published" value="1" @checked(old('published', $post?->published))>
    Publicar inmediatamente
</label>
@error('published')
    <p class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
@enderror

<div class="mt-6 flex flex-wrap gap-4">
    <button
        type="submit"
        class="rounded bg-arcilla px-5 py-2 font-semibold text-papel transition hover:bg-arcilla-hondo"
    >
        {{ $editing ? 'Guardar cambios' : 'Publicar entrada' }}
    </button>
    <a
        href="{{ route('admin.posts.index') }}"
        class="rounded border border-tinta/30 px-5 py-2 font-semibold transition hover:border-arcilla hover:text-arcilla"
    >
        Cancelar
    </a>
</div>
