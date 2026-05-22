<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $titulo ?? config('app.name') }} · VOLT</title>

    {{-- Tipografías: Bebas Neue (títulos/gym) + Inter (texto) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind y JS compilados por Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            font-feature-settings: 'cv11', 'ss01';
            font-optical-sizing: auto;
            letter-spacing: -0.01em;
        }
        /* Tipografía gym para títulos grandes */
        h1, h2, .titulo-gym {
            font-family: 'Bebas Neue', 'Inter', sans-serif;
            font-weight: 400;
            letter-spacing: 0.03em;
        }
        h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        /* Para números grandes de métricas */
        .numero-metrica {
            font-family: 'Bebas Neue', 'Inter', sans-serif;
            letter-spacing: 0.02em;
            font-weight: 400;
        }
    </style>
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">

@auth
    {{-- ============================================== --}}
    {{-- LAYOUT CON SIDEBAR (ESCRITORIO) + BOTTOM NAV (MÓVIL) --}}
    {{-- ============================================== --}}

    <div class="flex min-h-screen">

        {{-- =========================================== --}}
        {{-- SIDEBAR (escritorio) --}}
        {{-- =========================================== --}}
        <aside class="hidden lg:flex lg:flex-col fixed top-0 left-0 z-30 h-screen w-64 bg-[#0f172a] text-white border-r border-neutral-800">

            {{-- Logo grande, centrado --}}
            <div class="px-4 py-6 border-b border-neutral-800 flex justify-center">
                <a href="{{ auth()->user()->rol_id === 2 ? route('admin.panel') : route('panel') }}"
                   class="hover:opacity-90 transition">
                    <img src="{{ asset('img/volt-logo.svg') }}"
                         alt="VOLT"
                         style="height: 130px; width: 130px; object-fit: contain;">
                </a>
            </div>

            {{-- Navegación principal --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                @if (auth()->user()->rol_id === 2)
                    <a href="{{ route('admin.panel') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('admin.panel') ? 'bg-[#facc15] text-[#0f172a]' : 'text-neutral-300 hover:text-white hover:bg-white/5' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Panel admin
                    </a>
                    <a href="{{ route('admin.usuarios') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('admin.usuarios*') ? 'bg-[#facc15] text-[#0f172a]' : 'text-neutral-300 hover:text-white hover:bg-white/5' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Usuarios
                    </a>
                @else
                    <a href="{{ route('panel') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('panel') ? 'bg-[#facc15] text-[#0f172a]' : 'text-neutral-300 hover:text-white hover:bg-white/5' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Panel
                    </a>
                    <a href="{{ route('rutinas.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('rutinas.*') ? 'bg-[#facc15] text-[#0f172a]' : 'text-neutral-300 hover:text-white hover:bg-white/5' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Mis rutinas
                    </a>
                    <a href="{{ route('ejercicios.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('ejercicios.*') ? 'bg-[#facc15] text-[#0f172a]' : 'text-neutral-300 hover:text-white hover:bg-white/5' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Ejercicios
                    </a>
                    <a href="{{ route('entrenamientos.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('entrenamientos.*') ? 'bg-[#facc15] text-[#0f172a]' : 'text-neutral-300 hover:text-white hover:bg-white/5' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Entrenamientos
                    </a>
                @endif
            </nav>

            {{-- Perfil del usuario abajo --}}
            <div class="px-3 py-4 border-t border-neutral-800 space-y-2">
                <a href="{{ route('perfil.editar') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/5 transition">
                    @if (auth()->user()->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Avatar"
                             class="w-9 h-9 rounded-full object-cover border-2 {{ auth()->user()->rol_id === 2 ? 'border-[#facc15]' : 'border-neutral-700' }}">
                    @else
                        <span class="w-9 h-9 rounded-full {{ auth()->user()->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15] border-2 border-[#facc15]' : 'bg-[#facc15] text-[#0f172a]' }} flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                        </span>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->nombre }}</div>
                        @if (auth()->user()->rol_id === 2)
                            <span class="text-[10px] bg-[#facc15] text-[#0f172a] px-1.5 py-0.5 rounded-full font-bold uppercase">Admin</span>
                        @else
                            <div class="text-xs text-neutral-400 truncate">Mi perfil</div>
                        @endif
                    </div>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-red-400 hover:bg-white/5 hover:text-red-300 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H5a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v1"/>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- =========================================== --}}
        {{-- CONTENIDO PRINCIPAL --}}
        {{-- =========================================== --}}
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

            {{-- Header simple móvil (solo móvil) --}}
            <header class="lg:hidden bg-[#0f172a] text-white sticky top-0 z-20 border-b border-neutral-800">
                <div class="flex items-center justify-between px-4 h-16">
                    <a href="{{ auth()->user()->rol_id === 2 ? route('admin.panel') : route('panel') }}">
                        <img src="{{ asset('img/volt-logo.svg') }}"
                             alt="VOLT"
                             style="height: 48px; width: 48px; object-fit: contain;">
                    </a>

                    <a href="{{ route('perfil.editar') }}">
                        @if (auth()->user()->foto)
                            <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Avatar"
                                 class="w-9 h-9 rounded-full object-cover border-2 {{ auth()->user()->rol_id === 2 ? 'border-[#facc15]' : 'border-neutral-700' }}">
                        @else
                            <span class="w-9 h-9 rounded-full {{ auth()->user()->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15] border-2 border-[#facc15]' : 'bg-[#facc15] text-[#0f172a]' }} flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                            </span>
                        @endif
                    </a>
                </div>
            </header>

            {{-- Mensajes flash --}}
            <x-flash-messages />

            {{-- Contenido --}}
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8 pb-24 lg:pb-8">
                {{ $slot ?? '' }}
                @yield('contenido')
            </main>

            {{-- Footer (solo escritorio) --}}
            <footer class="hidden lg:block py-6 border-t border-neutral-200">
                <div class="text-center text-sm text-neutral-500">
                    <span class="font-semibold text-[#0f172a]">VOLT</span> · GymTracker — Proyecto Final DAW 2025/2026
                </div>
            </footer>
        </div>
    </div>

    {{-- =========================================== --}}
    {{-- BOTTOM NAV (móvil) --}}
    {{-- =========================================== --}}
    <nav class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white border-t border-neutral-200 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
        <div class="grid grid-cols-5 items-end h-16 px-2 pb-1">
            @if (auth()->user()->rol_id === 2)
                {{-- Bottom nav ADMIN --}}
                <a href="{{ route('admin.panel') }}"
                   class="flex flex-col items-center justify-center gap-1 py-2 transition
                   {{ request()->routeIs('admin.panel') ? 'text-[#0f172a]' : 'text-neutral-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-[10px] font-medium">Panel</span>
                </a>
                <a href="{{ route('admin.usuarios') }}"
                   class="flex flex-col items-center justify-center gap-1 py-2 transition
                   {{ request()->routeIs('admin.usuarios*') ? 'text-[#0f172a]' : 'text-neutral-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-[10px] font-medium">Usuarios</span>
                </a>
                <div></div>
                <a href="{{ route('perfil.editar') }}"
                   class="flex flex-col items-center justify-center gap-1 py-2 transition
                   {{ request()->routeIs('perfil.*') ? 'text-[#0f172a]' : 'text-neutral-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-[10px] font-medium">Perfil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex">
                    @csrf
                    <button type="submit" class="w-full flex flex-col items-center justify-center gap-1 py-2 text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H5a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-[10px] font-medium">Salir</span>
                    </button>
                </form>
            @else
                {{-- Bottom nav USUARIO con FAB central --}}
                <a href="{{ route('panel') }}"
                   class="flex flex-col items-center justify-center gap-1 py-2 transition
                   {{ request()->routeIs('panel') ? 'text-[#0f172a]' : 'text-neutral-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-[10px] font-medium">Inicio</span>
                </a>
                <a href="{{ route('rutinas.index') }}"
                   class="flex flex-col items-center justify-center gap-1 py-2 transition
                   {{ request()->routeIs('rutinas.*') ? 'text-[#0f172a]' : 'text-neutral-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-[10px] font-medium">Rutinas</span>
                </a>

                {{-- FAB central --}}
                <a href="{{ route('entrenamientos.create') }}"
                   class="relative flex items-center justify-center -mt-8 mx-auto bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] rounded-full w-14 h-14 shadow-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>

                <a href="{{ route('ejercicios.index') }}"
                   class="flex flex-col items-center justify-center gap-1 py-2 transition
                   {{ request()->routeIs('ejercicios.*') ? 'text-[#0f172a]' : 'text-neutral-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-[10px] font-medium">Ejercicios</span>
                </a>
                <a href="{{ route('entrenamientos.index') }}"
                   class="flex flex-col items-center justify-center gap-1 py-2 transition
                   {{ request()->routeIs('entrenamientos.*') && !request()->routeIs('entrenamientos.create') ? 'text-[#0f172a]' : 'text-neutral-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[10px] font-medium">Historial</span>
                </a>
            @endif
        </div>
    </nav>

@else
    {{-- ============================================== --}}
    {{-- LAYOUT PARA USUARIOS NO AUTENTICADOS (login, registro) --}}
    {{-- ============================================== --}}
    <x-flash-messages />
    <main class="min-h-screen">
        {{ $slot ?? '' }}
        @yield('contenido')
    </main>
@endauth

</body>
</html>
