@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">

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

    {{-- Mensaje de error --}}
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- BANNER cuenta bloqueada --}}
    @if (!$usuario->activo)
        <div class="bg-red-50 border-l-4 border-red-500 text-red-900 px-4 py-3 rounded-lg mb-4 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
            <div>
                <div class="text-sm font-bold">Cuenta bloqueada</div>
                <div class="text-xs">Este usuario no puede iniciar sesión hasta que un administrador desbloquee su cuenta.</div>
            </div>
        </div>
    @endif

    {{-- ============================== --}}
    {{-- TARJETA PRINCIPAL --}}
    {{-- ============================== --}}
    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden mb-6">

        {{-- Cabecera con gradient amarillo --}}
        <div class="bg-gradient-to-br from-[#ffd600]/20 to-[#ffd600]/5 px-8 py-6 border-b border-neutral-100">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-4">
                    @if ($usuario->foto)
                        <img src="{{ asset('storage/' . $usuario->foto) }}"
                             alt="Avatar de {{ $usuario->nombre }}"
                             class="w-20 h-20 rounded-full object-cover border-4 {{ $usuario->rol_id === 2 ? 'border-[#ffd600]' : 'border-white' }} shadow-md {{ !$usuario->activo ? 'opacity-50 grayscale' : '' }}">
                    @else
                        <div class="w-20 h-20 rounded-full {{ $usuario->rol_id === 2 ? 'bg-[#0f172a] text-[#ffd600] border-4 border-[#ffd600]' : 'bg-[#ffd600] text-[#0f172a] border-4 border-white' }} flex items-center justify-center font-bebas text-4xl shadow-md {{ !$usuario->activo ? 'opacity-50' : '' }}">
                            {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">{{ strtoupper($usuario->nombre) }}</h1>
                        <p class="text-sm text-neutral-600">{{ $usuario->email }}</p>
                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            <span class="inline-block text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full
                                {{ $usuario->rol_id === 2 ? 'bg-[#0f172a] text-[#ffd600]' : 'bg-white text-neutral-700 border border-neutral-200' }}">
                                {{ $usuario->rol->nombre }}
                            </span>
                            @if ($usuario->activo)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Activa
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    Bloqueada
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($usuario->id === auth()->id())
                    <span class="text-xs text-neutral-500 italic px-3 py-2 bg-white border border-neutral-200 rounded-lg">Esta es tu cuenta</span>
                @endif
            </div>
        </div>

        {{-- Acciones (solo si no es uno mismo) --}}
        @if ($usuario->id !== auth()->id())
            <div class="px-8 py-4 bg-neutral-50 border-b border-neutral-100 flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mr-2">Acciones:</span>

                {{-- Cambiar rol --}}
                <form action="{{ route('admin.usuarios.rol', $usuario) }}" method="POST" class="inline form-rol">
                    @csrf
                    @method('PATCH')
                    @if ($usuario->rol_id === 2)
                        <button type="button" onclick="abrirModalRol('degradar')"
                                class="text-sm bg-white border border-neutral-200 hover:bg-neutral-100 text-neutral-700 font-medium px-3 py-2 rounded-lg transition flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                            Degradar a usuario
                        </button>
                    @else
                        <button type="button" onclick="abrirModalRol('ascender')"
                                class="text-sm bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-3 py-2 rounded-lg transition flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            Ascender a admin
                        </button>
                    @endif
                </form>

                {{-- Bloquear / Desbloquear --}}
                <form action="{{ route('admin.usuarios.estado', $usuario) }}" method="POST" class="inline form-estado">
                    @csrf
                    @method('PATCH')
                    @if ($usuario->activo)
                        <button type="button" onclick="abrirModalEstado('bloquear')"
                                class="text-sm bg-orange-50 hover:bg-orange-100 text-orange-700 font-medium px-3 py-2 rounded-lg transition flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Bloquear
                        </button>
                    @else
                        <button type="button" onclick="abrirModalEstado('desbloquear')"
                                class="text-sm bg-green-50 hover:bg-green-100 text-green-700 font-medium px-3 py-2 rounded-lg transition flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Desbloquear
                        </button>
                    @endif
                </form>

                {{-- Eliminar --}}
                <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="inline form-eliminar">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="abrirModalEliminar()"
                            class="text-sm bg-red-50 hover:bg-red-100 text-red-700 font-medium px-3 py-2 rounded-lg transition flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                        </svg>
                        Eliminar usuario
                    </button>
                </form>
            </div>
        @endif

        {{-- Datos del usuario --}}
        <div class="px-8 py-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1">ID de usuario</div>
                <div class="text-sm font-medium text-[#0f172a]">#{{ $usuario->id }}</div>
            </div>
            <div>
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1">Fecha de registro</div>
                <div class="text-sm font-medium text-[#0f172a]">
                    {{ $usuario->fecha_creacion?->format('d/m/Y') ?? '—' }}
                </div>
            </div>
            <div>
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-1">Tipo de cuenta</div>
                <div class="text-sm font-medium text-[#0f172a] capitalize">{{ $usuario->rol->nombre }}</div>
            </div>
        </div>
    </div>

    {{-- ===================================================== --}}
    {{-- RESETEAR CONTRASEÑA --}}
    {{-- ===================================================== --}}
    @if ($usuario->id !== auth()->id())
        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-6 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1">RESETEAR CONTRASEÑA</h2>
                    <p class="text-xs text-neutral-500">
                        Asigna una contraseña nueva al usuario. Tendrás que comunicársela tú.
                    </p>
                </div>
            </div>

            <form id="form-resetear" action="{{ route('admin.usuarios.contrasena', $usuario) }}" method="POST"
                  class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                @csrf
                @method('PATCH')

                <div>
                    <label for="contrasena_nueva" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                        Nueva contraseña
                    </label>
                    <input
                        id="contrasena_nueva"
                        type="password"
                        name="contrasena_nueva"
                        required
                        minlength="6"
                        placeholder="Mínimo 6 caracteres"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none"
                    >
                </div>

                <div>
                    <label for="contrasena_nueva_confirmation" class="block text-xs font-semibold text-neutral-700 mb-1.5">
                        Confirmar contraseña
                    </label>
                    <input
                        id="contrasena_nueva_confirmation"
                        type="password"
                        name="contrasena_nueva_confirmation"
                        required
                        minlength="6"
                        placeholder="Repite la contraseña"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none"
                    >
                </div>

                <button type="button" onclick="abrirModalResetear()"
                        class="bg-[#0f172a] hover:bg-[#1e293b] text-white font-bold px-4 py-2.5 rounded-lg text-sm transition">
                    Resetear contraseña
                </button>
            </form>
        </div>
    @endif


    {{-- ============================================== --}}
    {{-- VISTA DIFERENTE SEGÚN EL ROL --}}
    {{-- ============================================== --}}

    @if ($usuario->rol_id === 2)
        {{-- VISTA ADMIN --}}

        <div class="bg-[#0f172a] text-white rounded-2xl p-6 mb-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-[#ffd600] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h2 class="font-bebas text-2xl tracking-wide pb-1">CUENTA DE ADMINISTRADOR</h2>
            </div>
            <p class="text-sm text-neutral-300">
                Este usuario tiene acceso completo al panel de administración. Puede gestionar usuarios, rutinas, ejercicios y entrenamientos de toda la plataforma.
            </p>
        </div>

        <h2 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1 mb-3">PERMISOS DEL ADMINISTRADOR</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="bg-white border border-neutral-200 rounded-xl p-5 flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-[#0f172a] mb-1">Gestión de usuarios</div>
                    <div class="text-xs text-neutral-500">Ver, ascender, degradar, bloquear y eliminar cuentas.</div>
                </div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-xl p-5 flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-[#0f172a] mb-1">Estadísticas globales</div>
                    <div class="text-xs text-neutral-500">Acceso a métricas del sistema completo.</div>
                </div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-xl p-5 flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-[#0f172a] mb-1">Acceso protegido</div>
                    <div class="text-xs text-neutral-500">Las rutas admin están protegidas por middleware.</div>
                </div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-xl p-5 flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-[#0f172a] mb-1">Sin actividad deportiva</div>
                    <div class="text-xs text-neutral-500">Los admins no registran rutinas ni entrenamientos.</div>
                </div>
            </div>
        </div>

    @else
        {{-- VISTA USUARIO NORMAL --}}

        <h2 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1 mb-3">ACTIVIDAD DEL USUARIO</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Rutinas</div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $estadisticas['rutinas'] }}</div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Ejercicios</div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $estadisticas['ejercicios'] }}</div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Entrenos totales</div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $estadisticas['entrenamientos'] }}</div>
            </div>

            <div class="bg-[#ffd600] border border-[#eab308] rounded-2xl p-5 shadow-sm">
                <div class="text-xs font-semibold text-[#854d0e] uppercase tracking-wider mb-2">Este mes</div>
                <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $estadisticas['entrenamientosMes'] }}</div>
            </div>
        </div>

        @if ($estadisticas['primerEntreno'] || $estadisticas['ultimoEntreno'])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                @if ($estadisticas['primerEntreno'])
                    <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                        <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Primer entrenamiento</div>
                        <div class="font-bebas text-2xl text-[#0f172a] leading-tight pb-1">
                            {{ $estadisticas['primerEntreno']->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-neutral-500 mt-1">
                            Hace {{ (int) floor($estadisticas['primerEntreno']->diffInDays(now())) }} días
                        </div>
                    </div>
                @endif

                @if ($estadisticas['ultimoEntreno'])
                    <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
                        <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-2">Último entrenamiento</div>
                        <div class="font-bebas text-2xl text-[#0f172a] leading-tight pb-1">
                            {{ $estadisticas['ultimoEntreno']->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-neutral-500 mt-1">
                            Hace {{ (int) floor($estadisticas['ultimoEntreno']->diffInDays(now())) }} días
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @if ($entrenamientosPorMes->count() > 0)
            <h2 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1 mb-3">ENTRENAMIENTOS POR MES</h2>
            <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden mb-6">
                <table class="w-full">
                    <thead class="bg-neutral-50 border-b border-neutral-200">
                        <tr>
                            <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Mes</th>
                            <th class="text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Sesiones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @php
                            $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
                        @endphp
                        @foreach ($entrenamientosPorMes as $registro)
                            <tr class="hover:bg-neutral-50 transition">
                                <td class="px-6 py-3 text-sm text-[#0f172a] capitalize font-semibold">
                                    {{ $meses[$registro->mes - 1] }} {{ $registro->anyo }}
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <span class="inline-block bg-[#ffd600]/20 text-[#854d0e] text-xs px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">
                                        {{ $registro->total }} {{ $registro->total === 1 ? 'sesión' : 'sesiones' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <h2 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1 mb-3">ÚLTIMOS ENTRENAMIENTOS</h2>
        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">
            @if ($ultimosEntrenamientos->isEmpty())
                <div class="p-8 text-center text-neutral-400 text-sm italic">
                    Este usuario aún no ha registrado entrenamientos.
                </div>
            @else
                <div class="divide-y divide-neutral-100">
                    @foreach ($ultimosEntrenamientos as $ent)
                        <div class="flex items-center justify-between p-5 hover:bg-neutral-50 transition">
                            <div>
                                <div class="font-semibold text-[#0f172a]">
                                    {{ $ent->fecha_entrenamiento->format('d/m/Y') }}
                                    <span class="text-xs text-neutral-400 ml-2 capitalize font-normal">
                                        {{ $ent->fecha_entrenamiento->locale('es')->isoFormat('dddd') }}
                                    </span>
                                </div>
                                <div class="text-xs text-neutral-500 mt-1 flex items-center gap-2">
                                    @if ($ent->rutina)
                                        <span class="bg-[#ffd600]/20 text-[#854d0e] px-2 py-0.5 rounded-full font-semibold">
                                            {{ $ent->rutina->nombre }}
                                        </span>
                                    @else
                                        <span class="italic">Sin rutina</span>
                                    @endif
                                    <span>·</span>
                                    <span>{{ $ent->detalles()->count() }} {{ $ent->detalles()->count() === 1 ? 'ejercicio' : 'ejercicios' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    @endif

</div>

{{-- =============== MODALES =============== --}}

{{-- Modal cambiar rol --}}
<div id="modal-rol" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0f172a]/70 backdrop-blur-sm" onclick="cerrarModal('modal-rol')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="bg-[#ffd600]/20 px-6 pt-6 pb-4 flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-[#ffd600] flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1" id="modal-rol-titulo">CAMBIAR ROL</h3>
                <p class="text-sm text-neutral-600 mt-1">Esta acción modificará los permisos del usuario.</p>
            </div>
        </div>
        <div class="px-6 py-5">
            <p class="text-sm text-neutral-700" id="modal-rol-texto"></p>
        </div>
        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button" onclick="cerrarModal('modal-rol')"
                    class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">
                Cancelar
            </button>
            <button type="button" onclick="document.querySelector('.form-rol').submit()"
                    class="px-5 py-2.5 text-sm font-bold text-[#0f172a] bg-[#ffd600] hover:bg-[#e6c000] rounded-lg transition">
                Confirmar cambio
            </button>
        </div>
    </div>
</div>

{{-- Modal bloquear/desbloquear --}}
<div id="modal-estado" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0f172a]/70 backdrop-blur-sm" onclick="cerrarModal('modal-estado')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="px-6 pt-6 pb-4 flex items-start gap-4" id="modal-estado-cabecera">
            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" id="modal-estado-icono-wrapper">
                <svg id="modal-estado-icono" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"></svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1" id="modal-estado-titulo"></h3>
                <p class="text-sm text-neutral-600 mt-1" id="modal-estado-subtitulo"></p>
            </div>
        </div>
        <div class="px-6 py-5">
            <p class="text-sm text-neutral-700" id="modal-estado-texto"></p>
        </div>
        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button" onclick="cerrarModal('modal-estado')"
                    class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">
                Cancelar
            </button>
            <button type="button" onclick="document.querySelector('.form-estado').submit()"
                    class="px-5 py-2.5 text-sm font-bold text-white rounded-lg transition" id="modal-estado-btn">
                Confirmar
            </button>
        </div>
    </div>
</div>

{{-- Modal resetear contraseña --}}
<div id="modal-resetear" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0f172a]/70 backdrop-blur-sm" onclick="cerrarModal('modal-resetear')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="bg-[#ffd600]/20 px-6 pt-6 pb-4 flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-[#ffd600] flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1">RESETEAR CONTRASEÑA</h3>
                <p class="text-sm text-neutral-600 mt-1">El usuario tendrá que usar la nueva contraseña.</p>
            </div>
        </div>
        <div class="px-6 py-5">
            <p class="text-sm text-neutral-700">
                ¿Confirmas que quieres cambiar la contraseña de <strong class="text-[#0f172a]">"{{ $usuario->nombre }}"</strong>?
            </p>
            <p class="text-xs text-neutral-500 mt-2">
                Tendrás que comunicársela tú manualmente. La contraseña antigua dejará de funcionar.
            </p>
        </div>
        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button" onclick="cerrarModal('modal-resetear')"
                    class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">
                Cancelar
            </button>
            <button type="button" onclick="document.getElementById('form-resetear').submit()"
                    class="px-5 py-2.5 text-sm font-bold text-white bg-[#0f172a] hover:bg-[#1e293b] rounded-lg transition">
                Resetear contraseña
            </button>
        </div>
    </div>
</div>

{{-- Modal eliminar usuario --}}
<div id="modal-eliminar" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0f172a]/70 backdrop-blur-sm" onclick="cerrarModal('modal-eliminar')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="bg-red-50 px-6 pt-6 pb-4 flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bebas text-2xl text-[#0f172a] tracking-wide pb-1">ELIMINAR USUARIO</h3>
                <p class="text-sm text-neutral-600 mt-1">Esta acción no se puede deshacer.</p>
            </div>
        </div>
        <div class="px-6 py-5">
            <p class="text-sm text-neutral-700">
                ¿Estás segura de que quieres eliminar al usuario <strong class="text-[#0f172a]">"{{ $usuario->nombre }}"</strong>?
            </p>
            <p class="text-xs text-neutral-500 mt-2">
                Se borrarán también <strong>todas sus rutinas, ejercicios y entrenamientos</strong>.
            </p>
        </div>
        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button" onclick="cerrarModal('modal-eliminar')"
                    class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">
                Cancelar
            </button>
            <button type="button" onclick="document.querySelector('.form-eliminar').submit()"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                </svg>
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

<script>
    const nombreUsuario = "{{ $usuario->nombre }}";

    function cerrarModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }

    function abrirModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function abrirModalRol(accion) {
        const titulo = document.getElementById('modal-rol-titulo');
        const texto = document.getElementById('modal-rol-texto');
        if (accion === 'ascender') {
            titulo.textContent = 'ASCENDER A ADMINISTRADOR';
            texto.innerHTML = `¿Confirmas que quieres convertir a <strong class="text-[#0f172a]">"${nombreUsuario}"</strong> en administrador? Tendrá acceso completo al panel de administración.`;
        } else {
            titulo.textContent = 'DEGRADAR A USUARIO';
            texto.innerHTML = `¿Confirmas que quieres degradar a <strong class="text-[#0f172a]">"${nombreUsuario}"</strong> a usuario normal? Perderá el acceso al panel de administración.`;
        }
        abrirModal('modal-rol');
    }

    function abrirModalEstado(accion) {
        const cabecera = document.getElementById('modal-estado-cabecera');
        const iconWrap = document.getElementById('modal-estado-icono-wrapper');
        const icono = document.getElementById('modal-estado-icono');
        const titulo = document.getElementById('modal-estado-titulo');
        const subtitulo = document.getElementById('modal-estado-subtitulo');
        const texto = document.getElementById('modal-estado-texto');
        const btn = document.getElementById('modal-estado-btn');

        if (accion === 'bloquear') {
            cabecera.className = 'bg-orange-50 px-6 pt-6 pb-4 flex items-start gap-4';
            iconWrap.className = 'w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0';
            icono.classList.add('text-orange-600');
            icono.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>';
            titulo.textContent = 'BLOQUEAR CUENTA';
            subtitulo.textContent = 'El usuario no podrá iniciar sesión.';
            texto.innerHTML = `¿Confirmas que quieres bloquear la cuenta de <strong class="text-[#0f172a]">"${nombreUsuario}"</strong>?`;
            btn.className = 'px-5 py-2.5 text-sm font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-lg transition';
        } else {
            cabecera.className = 'bg-green-50 px-6 pt-6 pb-4 flex items-start gap-4';
            iconWrap.className = 'w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0';
            icono.classList.add('text-green-600');
            icono.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>';
            titulo.textContent = 'DESBLOQUEAR CUENTA';
            subtitulo.textContent = 'El usuario podrá volver a iniciar sesión.';
            texto.innerHTML = `¿Confirmas que quieres desbloquear la cuenta de <strong class="text-[#0f172a]">"${nombreUsuario}"</strong>?`;
            btn.className = 'px-5 py-2.5 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg transition';
        }
        abrirModal('modal-estado');
    }

    function abrirModalResetear() {
        // Validar antes que las contraseñas coincidan
        const p1 = document.getElementById('contrasena_nueva').value;
        const p2 = document.getElementById('contrasena_nueva_confirmation').value;
        if (!p1 || p1.length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres.');
            return;
        }
        if (p1 !== p2) {
            alert('Las contraseñas no coinciden.');
            return;
        }
        abrirModal('modal-resetear');
    }

    function abrirModalEliminar() {
        abrirModal('modal-eliminar');
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            ['modal-rol', 'modal-estado', 'modal-resetear', 'modal-eliminar'].forEach(id => cerrarModal(id));
        }
    });
</script>

@endsection