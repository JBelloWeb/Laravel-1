<x-layouts.main>
    <x-slot:title>Iniciar sesión</x-slot:title>

    <div class="mx-auto max-w-md">
        <h1 class="font-display text-3xl font-bold">Iniciar sesión</h1>
        <p class="mt-2 text-tinta-suave">
            Accedé con tu cuenta para reseñar libros y, si sos administrador, entrar al panel.
        </p>

        <form action="{{ route('auth.login.process') }}" method="post" class="mt-6 border border-tinta/20 p-6">
            @csrf

            @if ($errors->any())
                <div class="mb-4 border-l-4 border-red-700 bg-red-50 px-4 py-3 text-sm text-red-900" role="alert">
                    <p class="font-semibold">No pudimos iniciar sesión:</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-semibold">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    autocomplete="email"
                    value="{{ old('email') }}"
                    @class([
                        'mt-1 w-full border border-tinta/30 px-3 py-2',
                        'border-red-500' => $errors->has('email'),
                    ])
                    aria-describedby="error-email"
                >
                @error('email')
                    <p id="error-email" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-semibold">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="current-password"
                    @class([
                        'mt-1 w-full border border-tinta/30 px-3 py-2',
                        'border-red-500' => $errors->has('password'),
                    ])
                    aria-describedby="error-password"
                >
                @error('password')
                    <p id="error-password" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="btn-solido mt-6 w-full px-5 py-3"
            >
                Ingresar
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-tinta-suave">
            ¿Todavía no tenés cuenta? Escribinos a
            <a href="mailto:hola@libreriasempere.test" class="font-semibold text-arcilla hover-linea">hola@libreriasempere.test</a>
            y te damos de alta.
        </p>
    </div>
</x-layouts.main>
