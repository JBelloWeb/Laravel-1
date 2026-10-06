<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{--
            $title llega desde el named slot <x-slot:title> de cada vista.
        --}}
        <title>{{ ($title ?? 'Inicio') }} · Librería Sempere</title>
        <meta name="description" content="{{ $description ?? 'Librería Sempere: catálogo de libros, reseñas y novedades del mundo editorial.' }}">

        {{-- Tipografías (con fallback local en public/css/style.css) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Source+Sans+3:wght@400;600;700&display=swap"
            rel="stylesheet"
        >

        {{-- Tailwind CSS v4 (browser build) --}}
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <style type="text/tailwindcss">
            @theme {
                --font-sans: "Source Sans 3", ui-sans-serif, system-ui, sans-serif;
                --font-display: "Fraunces", ui-serif, Georgia, serif;

                --color-papel: #fbf7f1;
                --color-papel-hondo: #f3ece2;
                --color-tinta: #241f1a;
                --color-tinta-suave: #57504a;
                --color-arcilla: #b45309;
                --color-arcilla-hondo: #92400e;
            }
        </style>

        {{-- Estilos propios (complementos y fallback de tipografía) --}}
        <link rel="stylesheet" href="{{ url('css/style.css') }}">
    </head>
    <body class="flex min-h-screen flex-col bg-papel font-sans text-tinta antialiased">
        {{-- Enlace de salto para navegar con teclado (accesibilidad) --}}
        <a
            href="#contenido"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-tinta focus:px-4 focus:py-2 focus:text-papel"
        >
            Saltar al contenido principal
        </a>

        <header class="border-b border-tinta/10 bg-papel-hondo">
            <nav
                aria-label="Navegación principal"
                class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4"
            >
                <a href="{{ route('index') }}" class="font-display text-2xl font-bold tracking-tight">
                    Librería <span class="text-arcilla">Sempere</span>
                </a>

                <ul class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm font-semibold">
                    <li>
                        <a
                            href="{{ route('index') }}"
                            @class(['hover-linea', 'text-arcilla' => request()->routeIs('index')])
                            @if (request()->routeIs('index')) aria-current="page" @endif
                        >Inicio</a>
                    </li>
                    <li>
                        <a
                            href="{{ route('books.index') }}"
                            @class(['hover-linea', 'text-arcilla' => request()->routeIs('books.*')])
                            @if (request()->routeIs('books.*')) aria-current="page" @endif
                        >Libros</a>
                    </li>
                    <li>
                        <a
                            href="{{ route('posts.index') }}"
                            @class(['hover-linea', 'text-arcilla' => request()->routeIs('posts.*')])
                            @if (request()->routeIs('posts.*')) aria-current="page" @endif
                        >Blog</a>
                    </li>

                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li>
                                <a
                                    href="{{ route('admin.home') }}"
                                    class="hover-linea"
                                    @if (request()->routeIs('admin.*')) aria-current="page" @endif
                                >Administración</a>
                            </li>
                        @endif
                        <li>
                            <form action="{{ route('auth.logout.process') }}" method="post">
                                @csrf
                                <button
                                    type="submit"
                                    class="hover-linea"
                                >
                                    Cerrar sesión ({{ auth()->user()->name }})
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a
                                href="{{ route('auth.login.form') }}"
                                class="btn-solido px-4 py-2"
                                @if (request()->routeIs('auth.login.*')) aria-current="page" @endif
                            >Iniciar sesión</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </header>

        <main id="contenido" class="mx-auto w-full max-w-6xl flex-1 px-4 py-8">
            {{--
                Mensajes de feedback flasheados por los controllers
                (claves 'feedback.message' y 'feedback.type', como en clase).
            --}}
            @if (session()->has('feedback.message'))
                @php($feedbackType = session('feedback.type', 'success'))
                <div
                    role="status"
                    @class([
                        'mb-6 border-l-4 px-4 py-3 text-sm font-medium',
                        'border-green-700 bg-green-50 text-green-900' => $feedbackType === 'success',
                        'border-red-700 bg-red-50 text-red-900' => $feedbackType === 'danger',
                        'border-amber-700 bg-amber-50 text-amber-900' => $feedbackType === 'warning',
                    ])
                >
                    {{ session('feedback.message') }}
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="mt-12 border-t border-tinta/10 bg-papel-hondo">
            <div class="mx-auto grid max-w-6xl gap-6 px-4 py-8 sm:grid-cols-2">
                <div>
                    <p class="font-display text-xl font-semibold">Librería Sempere</p>
                    <p class="mt-2 text-sm text-tinta-suave">
                    Curaduría de libros, novedades y reseñas para lectores curiosos.
                    </p>
                </div>
                <div class="text-sm sm:text-right">
                    <nav aria-label="Navegación del pie de página">
                        <ul class="flex flex-wrap gap-4 sm:justify-end">
                            <li><a href="{{ route('books.index') }}" class="hover-linea">Catálogo</a></li>
                            <li><a href="{{ route('posts.index') }}" class="hover-linea">Blog</a></li>
                            <li><a href="{{ route('auth.login.form') }}" class="hover-linea">Iniciar sesión</a></li>
                        </ul>
                    </nav>
                    <address class="mt-3 not-italic text-tinta-suave">
                        Calle de los Libros 123 · Buenos Aires ·
                        <a href="mailto:hola@libreriasempere.test" class="hover-linea">hola@libreriasempere.test</a>
                    </address>
                    <p class="mt-2 text-tinta-suave">© 2026 Librería Sempere. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
