@extends('layouts.app')

@section('contenido')
<div class="min-h-screen flex">

    {{-- ============================================ --}}
    {{-- COLUMNA IZQUIERDA: Foto motivacional (oculta en móvil) --}}
    {{-- ============================================ --}}
    <div class="hidden lg:flex lg:w-1/2 relative bg-[#0f172a]">
        <img src="{{ asset('img/auth-fondo.jpg') }}"
             alt="VOLT Gym"
             class="absolute inset-0 w-full h-full object-cover opacity-70">

        {{-- Overlay oscuro con degradado --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a]/80 via-[#0f172a]/40 to-transparent"></div>

        {{-- Texto motivacional --}}
        <div class="relative z-10 flex flex-col justify-end p-12 text-white w-full">
            <div class="mb-4">
                <div class="w-12 h-1 bg-[#facc15] mb-6"></div>
                <h2 class="titulo-gym text-6xl leading-none tracking-wide">
                    TRACK. <br>
                    TRAIN. <br>
                    <span class="text-[#facc15]">TRANSFORM.</span>
                </h2>
            </div>
            <p class="text-neutral-300 text-lg max-w-md">
                Tu app de fitness personal. Planifica, registra y supera tus límites.
            </p>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- COLUMNA DERECHA: Formulario --}}
    {{-- ============================================ --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-4 py-12 bg-neutral-50">
        <div class="w-full max-w-md">

            {{-- Logo VOLT grande y centrado --}}
            <div class="text-center mb-8">
                <img src="{{ asset('img/volt-logo.svg') }}"
                     alt="VOLT"
                     class="mx-auto"
                     style="height: 110px; width: 110px; object-fit: contain;">
                <h1 class="titulo-gym text-3xl text-[#0f172a] mt-4 tracking-wider">
                    BIENVENIDA DE NUEVO
                </h1>
                <p class="text-sm text-neutral-500 mt-1">Inicia sesión para continuar tu progreso</p>
            </div>

            {{-- Tarjeta del formulario --}}
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-700 mb-1.5">
                            Correo electrónico
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                            placeholder="tucorreo@ejemplo.com"
                        >
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div>
                        <label for="contrasena" class="block text-sm font-medium text-neutral-700 mb-1.5">
                            Contraseña
                        </label>
                        <input
                            id="contrasena"
                            type="password"
                            name="contrasena"
                            required
                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                            placeholder="••••••••"
                        >
                        @error('contrasena')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Recordarme --}}
                    <div class="flex items-center">
                        <input
                            id="recordar"
                            type="checkbox"
                            name="recordar"
                            class="h-4 w-4 rounded border-neutral-300 text-[#facc15] focus:ring-[#facc15]"
                        >
                        <label for="recordar" class="ml-2 text-sm text-neutral-700">
                            Recordar sesión
                        </label>
                    </div>

                    {{-- Botón --}}
                    <button
                        type="submit"
                        class="w-full bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-bold py-3 rounded-lg transition shadow-sm hover:shadow-md tracking-wide"
                    >
                        ENTRAR
                    </button>
                </form>

                {{-- Enlace a registro --}}
                <p class="text-center text-sm text-neutral-600 mt-6">
                    ¿No tienes cuenta?
                    <a href="{{ route('registro') }}" class="text-[#0f172a] font-semibold hover:text-[#facc15] transition">
                        Regístrate gratis
                    </a>
                </p>
            </div>

            {{-- Footer mini --}}
            <p class="text-center text-xs text-neutral-400 mt-6">
                VOLT · GymTracker — Proyecto Final DAW 2025/2026
            </p>
        </div>
    </div>

</div>
@endsection
