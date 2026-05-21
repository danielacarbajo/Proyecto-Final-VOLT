<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $titulo ?? config('app.name') }} · VOLT</title>

    {{-- Tailwind y JS compilados por Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">

    {{-- Cabecera (solo si el usuario está autenticado) --}}
    @auth
        <header class="bg-[#0f172a] text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    {{-- Logo --}}
                    <a href="{{ route('panel') }}" class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-[#facc15]">VOLT</span>
                        <span class="text-sm text-neutral-400 hidden sm:inline">GymTracker</span>
                    </a>

                    {{-- Menú principal --}}
                    <nav class="hidden md:flex items-center gap-6">
                        <a href="{{ route('panel') }}" class="text-sm hover:text-[#facc15] transition">Panel</a>
                        {{-- Aquí iremos añadiendo más enlaces conforme creemos las secciones --}}
                    </nav>

                    {{-- Usuario y logout --}}
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-neutral-300 hidden sm:inline">
                            Hola, <strong class="text-white">{{ auth()->user()->nombre }}</strong>
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm px-3 py-1.5 rounded-md bg-neutral-800 hover:bg-neutral-700 transition">
                                Salir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
    @endauth

    {{-- Mensajes flash --}}
    @if (session('exito'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md">
                {{ session('exito') }}
            </div>
        </div>
    @endif

    {{-- Contenido principal --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot ?? '' }}
        @yield('contenido')
    </main>

    {{-- Footer simple --}}
    <footer class="mt-12 py-6 border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-neutral-500">
            VOLT · GymTracker — Proyecto Final DAW 2025/2026
        </div>
    </footer>

</body>
</html>
