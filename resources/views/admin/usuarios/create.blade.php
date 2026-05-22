@extends('layouts.app')

@section('contenido')
<div class="max-w-2xl mx-auto">

    {{-- Cabecera --}}
    <div class="mb-8">
        <a href="{{ route('admin.usuarios') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
            ← Volver a usuarios
        </a>
        <h1 class="text-3xl font-bold text-[#0f172a] mt-2">Crear nuevo usuario</h1>
        <p class="text-sm text-neutral-500 mt-1">Crea una cuenta nueva como administrador.</p>
    </div>

    {{-- Formulario --}}
    <div class="bg-white border border-neutral-200 rounded-2xl p-8 shadow-sm">
        <form method="POST" action="{{ route('admin.usuarios.crear.guardar') }}" class="space-y-5">
            @csrf

            {{-- Nombre --}}
            <div>
                <label for="nombre" class="block text-sm font-medium text-neutral-700 mb-1">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input
                    id="nombre"
                    type="text"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    required
                    autofocus
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    placeholder="Nombre completo"
                >
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    placeholder="usuario@volt.com"
                >
            </div>

            {{-- Contraseña --}}
            <div>
                <label for="contrasena" class="block text-sm font-medium text-neutral-700 mb-1">
                    Contraseña <span class="text-red-500">*</span>
                </label>
                <input
                    id="contrasena"
                    type="password"
                    name="contrasena"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    placeholder="Mínimo 6 caracteres"
                >
            </div>

            {{-- Confirmar contraseña --}}
            <div>
                <label for="contrasena_confirmation" class="block text-sm font-medium text-neutral-700 mb-1">
                    Confirmar contraseña <span class="text-red-500">*</span>
                </label>
                <input
                    id="contrasena_confirmation"
                    type="password"
                    name="contrasena_confirmation"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    placeholder="Repite la contraseña"
                >
            </div>

            {{-- Rol --}}
            <div>
                <label for="rol_id" class="block text-sm font-medium text-neutral-700 mb-1">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select
                    id="rol_id"
                    name="rol_id"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none bg-white"
                >
                    <option value="1" {{ old('rol_id', '1') == '1' ? 'selected' : '' }}>Usuario</option>
                    <option value="2" {{ old('rol_id') == '2' ? 'selected' : '' }}>Administrador</option>
                </select>
                <p class="text-xs text-neutral-500 mt-1">
                    El rol "Administrador" tiene acceso completo a la gestión de la plataforma.
                </p>
            </div>

            {{-- Botones --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-neutral-100">
                <a href="{{ route('admin.usuarios') }}"
                   class="text-sm text-neutral-600 hover:text-[#0f172a] font-medium px-4 py-2.5 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-6 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
                    Crear usuario
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
