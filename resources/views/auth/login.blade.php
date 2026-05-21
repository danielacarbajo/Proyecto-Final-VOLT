@extends('layouts.app')

@section('contenido')
<div class="min-h-[calc(100vh-12rem)] flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        {{-- Logo VOLT --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-[#0f172a]">
                <span class="text-[#facc15]">⚡</span> VOLT
            </h1>
            <p class="text-sm text-neutral-500 mt-2">Inicia sesión para continuar</p>
        </div>

        {{-- Tarjeta del formulario --}}
        <div class="bg-white rounded-2xl shadow-lg border border-neutral-200 p-8">
            <h2 class="text-2xl font-semibold text-[#0f172a] mb-6">Iniciar sesión</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">
                        Correo electrónico
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                        placeholder="tucorreo@ejemplo.com"
                    >
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="contrasena" class="block text-sm font-medium text-neutral-700 mb-1">
                        Contraseña
                    </label>
                    <input
                        id="contrasena"
                        type="password"
                        name="contrasena"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                        placeholder="Tu contraseña"
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
                    class="w-full bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold py-2.5 rounded-lg transition shadow-sm hover:shadow-md"
                >
                    Entrar
                </button>
            </form>

            {{-- Enlace a registro --}}
            <p class="text-center text-sm text-neutral-600 mt-6">
                ¿No tienes cuenta?
                <a href="{{ route('registro') }}" class="text-[#0f172a] font-medium hover:underline">
                    Regístrate
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
