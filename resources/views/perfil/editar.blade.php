@extends('layouts.app')

@section('contenido')
<div class="max-w-3xl mx-auto">

    {{-- Cabecera --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#0f172a]">Mi perfil</h1>
        <p class="text-sm text-neutral-500 mt-1">Gestiona tus datos personales y tu contraseña.</p>
    </div>

    {{-- ============================================== --}}
    {{-- FORMULARIO 1: Foto + Datos básicos --}}
    {{-- ============================================== --}}
    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8 mb-6">

        <h2 class="text-lg font-semibold text-[#0f172a] mb-6">Datos personales</h2>

        <form method="POST" action="{{ route('perfil.actualizar') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Avatar y subida de foto --}}
            <div class="flex items-center gap-6 pb-6 border-b border-neutral-100">

                {{-- Previsualización del avatar --}}
                <div class="relative">
                    <div id="previsualAvatar" class="w-24 h-24 rounded-full overflow-hidden {{ $usuario->rol_id === 2 ? 'bg-[#0f172a]' : 'bg-[#facc15]' }} flex items-center justify-center">
                        @if ($usuario->foto)
                            <img src="{{ asset('storage/' . $usuario->foto) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <span class="font-bold text-3xl {{ $usuario->rol_id === 2 ? 'text-[#facc15]' : 'text-[#0f172a]' }}">
                                {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Botones de gestión de la foto --}}
                <div class="flex-1">
                    <label for="foto" class="block text-sm font-medium text-neutral-700 mb-2">
                        Foto de perfil
                    </label>
                    <input
                        id="foto"
                        type="file"
                        name="foto"
                        accept="image/jpeg,image/png,image/webp"
                        onchange="previsualizar(event)"
                        class="block w-full text-sm text-neutral-700
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-lg file:border-0
                               file:text-sm file:font-semibold
                               file:bg-[#facc15] file:text-[#0f172a]
                               hover:file:bg-[#eab308]
                               cursor-pointer"
                    >
                    <p class="text-xs text-neutral-500 mt-1">JPG, PNG o WEBP. Máximo 2 MB.</p>
                    @error('foto')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Eliminar foto actual --}}
                    @if ($usuario->foto)
                        <button type="button"
                                onclick="document.getElementById('formEliminarFoto').submit();"
                                class="text-xs text-red-600 hover:text-red-800 mt-2 inline-block">
                            Eliminar foto actual
                        </button>
                    @endif
                </div>
            </div>

            {{-- Nombre --}}
            <div>
                <label for="nombre" class="block text-sm font-medium text-neutral-700 mb-1">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input
                    id="nombre"
                    type="text"
                    name="nombre"
                    value="{{ old('nombre', $usuario->nombre) }}"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                >
                @error('nombre')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
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
                    value="{{ old('email', $usuario->email) }}"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                >
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón guardar --}}
            <div>
                <button type="submit"
                        class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-6 py-2.5 rounded-lg transition shadow-sm hover:shadow-md">
                    Guardar cambios
                </button>
            </div>

        </form>

    </div>

    {{-- ============================================== --}}
    {{-- FORMULARIO 2: Cambiar contraseña --}}
    {{-- ============================================== --}}
    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8">

        <h2 class="text-lg font-semibold text-[#0f172a] mb-2">Cambiar contraseña</h2>
        <p class="text-sm text-neutral-500 mb-6">Usa una contraseña segura con al menos 6 caracteres.</p>

        <form method="POST" action="{{ route('perfil.contrasena') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="contrasena_actual" class="block text-sm font-medium text-neutral-700 mb-1">
                    Contraseña actual <span class="text-red-500">*</span>
                </label>
                <input
                    id="contrasena_actual"
                    type="password"
                    name="contrasena_actual"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                >
                @error('contrasena_actual')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="contrasena_nueva" class="block text-sm font-medium text-neutral-700 mb-1">
                    Nueva contraseña <span class="text-red-500">*</span>
                </label>
                <input
                    id="contrasena_nueva"
                    type="password"
                    name="contrasena_nueva"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                >
                @error('contrasena_nueva')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="contrasena_nueva_confirmation" class="block text-sm font-medium text-neutral-700 mb-1">
                    Repite la nueva contraseña <span class="text-red-500">*</span>
                </label>
                <input
                    id="contrasena_nueva_confirmation"
                    type="password"
                    name="contrasena_nueva_confirmation"
                    required
                    class="w-full px-4 py-2.5 rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                >
            </div>

            <div>
                <button type="submit"
                        class="bg-[#0f172a] hover:bg-[#1e293b] text-white font-semibold px-6 py-2.5 rounded-lg transition">
                    Cambiar contraseña
                </button>
            </div>

        </form>

    </div>

</div>

{{-- Formulario invisible para eliminar la foto --}}
@if ($usuario->foto)
    <form id="formEliminarFoto" method="POST" action="{{ route('perfil.foto.eliminar') }}"
          onsubmit="return confirm('¿Seguro que quieres eliminar tu foto de perfil?');"
          style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endif

<script>
    function previsualizar(event) {
        const archivo = event.target.files[0];
        if (!archivo) return;

        const lector = new FileReader();
        lector.onload = function(e) {
            const contenedor = document.getElementById('previsualAvatar');
            contenedor.innerHTML = `<img src="${e.target.result}" alt="Avatar" class="w-full h-full object-cover">`;
        };
        lector.readAsDataURL(archivo);
    }
</script>
@endsection
