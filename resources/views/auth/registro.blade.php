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
                    EMPIEZA <br>
                    TU <br>
                    <span class="text-[#facc15]">JOURNEY.</span>
                </h2>
            </div>
            <p class="text-neutral-300 text-lg max-w-md">
                Únete a VOLT y empieza a registrar tus entrenamientos hoy mismo.
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
                    CREA TU CUENTA
                </h1>
                <p class="text-sm text-neutral-500 mt-1">Empieza a registrar tus entrenamientos</p>
            </div>

            {{-- Tarjeta del formulario --}}
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 p-8">
                <form method="POST" action="{{ route('registro') }}" class="space-y-5">
                    @csrf

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-neutral-700 mb-1.5">
                            Nombre
                        </label>
                        <input
                            id="nombre"
                            type="text"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            required
                            autofocus
                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                            placeholder="Tu nombre"
                        >
                        @error('nombre')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

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
                            placeholder="Mínimo 6 caracteres"
                        >
                        @error('contrasena')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div>
                        <label for="contrasena_confirmation" class="block text-sm font-medium text-neutral-700 mb-1.5">
                            Confirmar contraseña
                        </label>
                        <input
                            id="contrasena_confirmation"
                            type="password"
                            name="contrasena_confirmation"
                            required
                            class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                            placeholder="Repite la contraseña"
                        >
                    </div>

                    {{-- Botón --}}
                    <button
                        type="submit"
                        class="w-full bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-bold py-3 rounded-lg transition shadow-sm hover:shadow-md tracking-wide"
                    >
                        CREAR CUENTA
                    </button>
                </form>

                {{-- Enlace a login --}}
                <p class="text-center text-sm text-neutral-600 mt-6">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="text-[#0f172a] font-semibold hover:text-[#facc15] transition">
                        Inicia sesión
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
