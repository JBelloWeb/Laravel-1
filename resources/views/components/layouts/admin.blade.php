<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ ($title ?? 'Panel') }} · Admin · Librería Umbral</title>

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

        <link rel="stylesheet" href="{{ url('css/style.css') }}">
    </head>
    <body class="min-h-screen bg-papel-hondo font-sans text-tinta antialiased">
        <a
            href="#contenido"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-tinta focus:px-4 focus:py-2 focus:text-papel"
        >
            Saltar al contenido principal
        </a>

        <div class="mx-auto flex min-h-screen max-w-7xl flex-col md:flex-row">
            {{--
                Panel de administración: navegación lateral con las secciones
                del ABM y acceso de vuelta al sitio público.
            --}}
            <nav
                aria-label="Navegación de administración"
                class="w-full border-b border-tinta/10 bg-tinta text-papel md:min-h-screen md:w-64 md:border-b-0 md:border-r"
            >
                <div class="px-4 py-4">
                    <a href="{{ route('index') }}" class="font-display text-xl font-bold">
                        Umbral <span class="text-amber-500">Admin</span>
                    </a>
                </div>

                <ul class="flex flex-col gap-1 px-2 pb-4 text-sm font-semibold md:mt-2">
                    <li>
                        <a
                            href="{{ route('admin.home') }}"
                            @class([
                                'block rounded px-3 py-2 transition hover:bg-white/10',
                                'bg-white/15' => request()->routeIs('admin.home'),
                            ])
                            @if (request()->routeIs('admin.home')) aria-current="page" @endif
                        >Dashboard</a>
                    </li>
                    <li>
                        <a
                            href="{{ route('admin.posts.index') }}"
                            @class([
                                'block rounded px-3 py-2 transition hover:bg-white/10',
                                'bg-white/15' => request()->routeIs('admin.posts.*'),
                            ])
                            @if (request()->routeIs('admin.posts.*')) aria-current="page" @endif
                        >Entradas del blog</a>
                    </li>
                    <li>
                        <a href="{{ route('index') }}" class="block rounded px-3 py-2 transition hover:bg-white/10">
                            Ver el sitio
                        </a>
                    </li>
                    <li class="mt-2 border-t border-white/20 pt-2">
                        <form action="{{ route('auth.logout.process') }}" method="post">
                            @csrf
                            <button type="submit" class="rounded px-3 py-2 text-left transition hover:bg-white/10">
                                Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            <main id="contenido" class="flex-1 px-4 py-8">
                @if (session()->has('feedback.message'))
                    @php($feedbackType = session('feedback.type', 'success'))
                    <div
                        role="status"
                        @class([
                            'mb-6 rounded-lg border px-4 py-3 text-sm font-medium',
                            'border-green-300 bg-green-50 text-green-900' => $feedbackType === 'success',
                            'border-red-300 bg-red-50 text-red-900' => $feedbackType === 'danger',
                            'border-amber-300 bg-amber-50 text-amber-900' => $feedbackType === 'warning',
                        ])
                    >
                        {{ session('feedback.message') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
