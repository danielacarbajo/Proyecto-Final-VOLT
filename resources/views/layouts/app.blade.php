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
                    {{-- Logo (cambia el destino según el rol) --}}
                    <a href="{{ auth()->user()->rol_id === 2 ? route('admin.panel') : route('panel') }}" class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-[#facc15]">VOLT</span>
                        <span class="text-sm text-neutral-400 hidden sm:inline">GymTracker</span>
                    </a>

                    {{-- Navegación dinámica según rol --}}
                    <nav class="hidden md:flex items-center gap-6">
                        @if (auth()->user()->rol_id === 2)
                            {{-- Menú para ADMINISTRADOR --}}
                            <a href="{{ route('admin.panel') }}" class="text-sm hover:text-[#facc15] transition">Panel admin</a>
                            <a href="{{ route('admin.usuarios') }}" class="text-sm hover:text-[#facc15] transition">Usuarios</a>
                        @else
                            {{-- Menú para USUARIO NORMAL --}}
                            <a href="{{ route('panel') }}" class="text-sm hover:text-[#facc15] transition">Panel</a>
                            <a href="{{ route('rutinas.index') }}" class="text-sm hover:text-[#facc15] transition">Mis rutinas</a>
                            <a href="{{ route('ejercicios.index') }}" class="text-sm hover:text-[#facc15] transition">Ejercicios</a>
                            <a href="{{ route('entrenamientos.index') }}" class="text-sm hover:text-[#facc15] transition">Entrenamientos</a>
                        @endif
                    </nav>

                    {{-- Usuario (enlace al perfil) y logout --}}
                    <div class="flex items-center gap-4">
                        <a href="{{ route('perfil.editar') }}" class="text-sm text-neutral-300 hover:text-white transition hidden sm:flex items-center gap-2">
                            @if (auth()->user()->foto)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-neutral-700">
                            @else
                                <span class="w-8 h-8 rounded-full {{ auth()->user()->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15] border border-[#facc15]' : 'bg-[#facc15] text-[#0f172a]' }} flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                                </span>
                            @endif
                            <span>
                                Hola, <strong class="text-white">{{ auth()->user()->nombre }}</strong>
                                @if (auth()->user()->rol_id === 2)
                                    <span class="ml-1 text-xs bg-[#facc15] text-[#0f172a] px-1.5 py-0.5 rounded-full font-bold">ADMIN</span>
                                @endif
                            </span>
                        </a>

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

    {{-- Mensajes flash (toasts flotantes) --}}
    <x-flash-messages />

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
