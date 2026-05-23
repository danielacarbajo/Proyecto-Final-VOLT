@extends('layouts.app')

@section('contenido')
<div class="max-w-2xl mx-auto">

    {{-- Botón Volver (PILL) --}}
    <div class="mb-6">
        <a href="{{ route('admin.usuarios') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-200 rounded-lg shadow-sm hover:shadow-md hover:border-neutral-300 transition text-sm font-medium text-neutral-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a usuarios
        </a>
    </div>

    {{-- Cabecera --}}
    <div class="mb-8">
        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">CREAR NUEVO USUARIO</h1>
        <p class="text-sm text-neutral-500 mt-1">Da de alta una cuenta nueva en la plataforma.</p>
    </div>

    {{-- Formulario --}}
    <div class="bg-white border border-neutral-200 rounded-2xl p-8 shadow-sm">
        <form method="POST" action="{{ route('admin.usuarios.crear.guardar') }}" class="space-y-5">
            @csrf

            {{-- Nombre --}}
            <div>
                <label for="nombre" class="block text-sm font-semibold text-neutral-700 mb-2">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input
                    id="nombre"
                    type="text"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none"
                    placeholder="Nombre completo"
                >
                @error('nombre')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-neutral-700 mb-2">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none"
                    placeholder="usuario@volt.com"
                >
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contraseñas (2 columnas) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="contrasena" class="block text-sm font-semibold text-neutral-700 mb-2">
                        Contraseña <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            id="contrasena"
                            type="password"
                            name="contrasena"
                            required
                            class="w-full px-4 py-3 pr-11 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none"
                            placeholder="Mínimo 6 caracteres"
                        >
                        <button type="button" onclick="togglePassword('contrasena', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-[#0f172a] transition">
                            <svg class="eye-open h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-closed h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('contrasena')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contrasena_confirmation" class="block text-sm font-semibold text-neutral-700 mb-2">
                        Confirmar <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            id="contrasena_confirmation"
                            type="password"
                            name="contrasena_confirmation"
                            required
                            class="w-full px-4 py-3 pr-11 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none"
                            placeholder="Repite la contraseña"
                        >
                        <button type="button" onclick="togglePassword('contrasena_confirmation', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-[#0f172a] transition">
                            <svg class="eye-open h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-closed h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Rol --}}
            <div>
                <label for="rol_id" class="block text-sm font-semibold text-neutral-700 mb-2">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select
                    id="rol_id"
                    name="rol_id"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none bg-white"
                >
                    <option value="1" {{ old('rol_id', '1') == '1' ? 'selected' : '' }}>Usuario</option>
                    <option value="2" {{ old('rol_id') == '2' ? 'selected' : '' }}>Administrador</option>
                </select>
                <p class="text-xs text-neutral-500 mt-2 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    El rol "Administrador" tiene acceso completo a la gestión de la plataforma.
                </p>
            </div>

            {{-- Botones --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-neutral-100">
                <a href="{{ route('admin.usuarios') }}"
                   class="text-sm text-neutral-500 hover:text-[#0f172a] font-medium px-3 py-2 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-6 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Crear usuario
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');

        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>

@endsection