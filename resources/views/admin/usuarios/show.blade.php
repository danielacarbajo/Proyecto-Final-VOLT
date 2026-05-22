@extends('layouts.app')

@section('contenido')
<div class="max-w-5xl mx-auto">

    {{-- Cabecera --}}
    <div class="mb-8">
        <a href="{{ route('admin.usuarios') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
            ← Volver a usuarios
        </a>
    </div>

    {{-- Mensaje de error específico --}}
    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- BANNER cuenta bloqueada --}}
    @if (!$usuario->activo)
        <div class="bg-red-50 border-l-4 border-red-500 text-red-900 px-4 py-3 rounded-lg mb-4 flex items-center gap-3">
            <span class="text-2xl">🚫</span>
            <div>
                <div class="text-sm font-semibold">Cuenta bloqueada</div>
                <div class="text-xs">Este usuario no puede iniciar sesión hasta que un administrador desbloquee su cuenta.</div>
            </div>
        </div>
    @endif

    {{-- Tarjeta principal con datos del usuario --}}
    <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-8 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-4">
                @if ($usuario->foto)
                    <img src="{{ asset('storage/' . $usuario->foto) }}"
                         alt="Avatar de {{ $usuario->nombre }}"
                         class="w-16 h-16 rounded-full object-cover border-2 {{ $usuario->rol_id === 2 ? 'border-[#facc15]' : 'border-neutral-200' }} {{ !$usuario->activo ? 'opacity-50 grayscale' : '' }}">
                @else
                    <div class="w-16 h-16 rounded-full {{ $usuario->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15]' : 'bg-[#facc15] text-[#0f172a]' }} flex items-center justify-center font-bold text-2xl {{ !$usuario->activo ? 'opacity-50' : '' }}">
                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-3xl font-bold text-[#0f172a]">{{ $usuario->nombre }}</h1>
                    <p class="text-sm text-neutral-500 mt-1">{{ $usuario->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full
                            {{ $usuario->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15]' : 'bg-neutral-100 text-neutral-700' }}">
                            {{ $usuario->rol->nombre }}
                        </span>
                        @if ($usuario->activo)
                            <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full bg-green-100 text-green-800">
                                ✓ Activa
                            </span>
                        @else
                            <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full bg-red-100 text-red-800">
                                🚫 Bloqueada
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Acciones (solo si no es uno mismo) --}}
            @if ($usuario->id !== auth()->id())
                <div class="flex items-center gap-2 flex-wrap justify-end">
                    {{-- Cambiar rol --}}
                    <form action="{{ route('admin.usuarios.rol', $usuario) }}" method="POST" class="inline"
                          onsubmit="return confirm('¿Seguro que quieres cambiar el rol de {{ $usuario->nombre }}?');">
                        @csrf
                        @method('PATCH')
                        @if ($usuario->rol_id === 2)
                            <button type="submit" class="text-sm bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium px-4 py-2 rounded-lg transition">
                                ↓ Degradar a usuario
                            </button>
                        @else
                            <button type="submit" class="text-sm bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-4 py-2 rounded-lg transition">
                                ↑ Ascender a admin
                            </button>
                        @endif
                    </form>

                    {{-- Bloquear / Desbloquear --}}
                    <form action="{{ route('admin.usuarios.estado', $usuario) }}" method="POST" class="inline"
                          onsubmit="return confirm('{{ $usuario->activo ? '¿Seguro que quieres bloquear la cuenta de ' . $usuario->nombre . '? No podrá iniciar sesión hasta que la desbloquees.' : '¿Seguro que quieres desbloquear la cuenta de ' . $usuario->nombre . '?' }}');">
                        @csrf
                        @method('PATCH')
                        @if ($usuario->activo)
                            <button type="submit" class="text-sm bg-orange-50 hover:bg-orange-100 text-orange-700 font-medium px-4 py-2 rounded-lg transition">
                                🚫 Bloquear
                            </button>
                        @else
                            <button type="submit" class="text-sm bg-green-50 hover:bg-green-100 text-green-700 font-medium px-4 py-2 rounded-lg transition">
                                ✓ Desbloquear
                            </button>
                        @endif
                    </form>

                    {{-- Eliminar --}}
                    <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="inline"
                          onsubmit="return confirm('¿Seguro que quieres eliminar a {{ $usuario->nombre }}? Se borrarán todas sus rutinas, ejercicios y entrenamientos.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg transition">
                            Eliminar usuario
                        </button>
                    </form>
                </div>
            @else
                <span class="text-xs text-neutral-400 italic px-3 py-2 bg-neutral-50 rounded-lg">Esta es tu cuenta</span>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-6 border-t border-neutral-100">
            <div>
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">ID de usuario</div>
                <div class="text-sm text-[#0f172a]">#{{ $usuario->id }}</div>
            </div>
            <div>
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Fecha de registro</div>
                <div class="text-sm text-[#0f172a]">
                    {{ $usuario->fecha_creacion?->format('d/m/Y') ?? '—' }}
                </div>
            </div>
            <div>
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Tipo de cuenta</div>
                <div class="text-sm text-[#0f172a] capitalize">{{ $usuario->rol->nombre }}</div>
            </div>
        </div>
    </div>

    {{-- ===================================================== --}}
    {{-- RESETEAR CONTRASEÑA (solo si no es uno mismo) --}}
    {{-- ===================================================== --}}
    @if ($usuario->id !== auth()->id())
        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm p-6 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">🔑</span>
                <div>
                    <h2 class="text-lg font-semibold text-[#0f172a]">Resetear contraseña</h2>
                    <p class="text-xs text-neutral-500 mt-0.5">
                        Asigna una contraseña nueva al usuario. Tendrás que comunicársela tú.
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.usuarios.contrasena', $usuario) }}" method="POST"
                  onsubmit="return confirm('¿Seguro que quieres cambiar la contraseña de {{ $usuario->nombre }}?');"
                  class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                @csrf
                @method('PATCH')

                <div>
                    <label for="contrasena_nueva" class="block text-xs font-semibold text-neutral-700 mb-1">
                        Nueva contraseña
                    </label>
                    <input
                        id="contrasena_nueva"
                        type="password"
                        name="contrasena_nueva"
                        required
                        minlength="6"
                        placeholder="Mínimo 6 caracteres"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    >
                </div>

                <div>
                    <label for="contrasena_nueva_confirmation" class="block text-xs font-semibold text-neutral-700 mb-1">
                        Confirmar contraseña
                    </label>
                    <input
                        id="contrasena_nueva_confirmation"
                        type="password"
                        name="contrasena_nueva_confirmation"
                        required
                        minlength="6"
                        placeholder="Repite la contraseña"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                    >
                </div>

                <button type="submit"
                        class="bg-[#0f172a] hover:bg-[#1e293b] text-white font-medium px-4 py-2 rounded-lg text-sm transition">
                    Resetear contraseña
                </button>
            </form>
        </div>
    @endif


    {{-- ============================================== --}}
    {{-- VISTA DIFERENTE SEGÚN EL ROL DEL USUARIO --}}
    {{-- ============================================== --}}

    @if ($usuario->rol_id === 2)
        {{-- ===== VISTA PARA UN ADMINISTRADOR ===== --}}

        <div class="bg-[#0f172a] text-white rounded-2xl p-6 mb-6">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-2xl">🛡️</span>
                <h2 class="text-lg font-semibold">Cuenta de administrador</h2>
            </div>
            <p class="text-sm text-neutral-300">
                Este usuario tiene acceso completo al panel de administración. Puede gestionar usuarios, rutinas, ejercicios y entrenamientos de toda la plataforma.
            </p>
        </div>

        <h2 class="text-lg font-semibold text-[#0f172a] mb-3">Permisos del administrador</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="bg-white border border-neutral-200 rounded-xl p-5 flex items-start gap-3">
                <div class="text-2xl">👥</div>
                <div>
                    <div class="font-semibold text-[#0f172a] mb-1">Gestión de usuarios</div>
                    <div class="text-xs text-neutral-500">Ver, ascender, degradar, bloquear y eliminar cuentas.</div>
                </div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-xl p-5 flex items-start gap-3">
                <div class="text-2xl">📊</div>
                <div>
                    <div class="font-semibold text-[#0f172a] mb-1">Estadísticas globales</div>
                    <div class="text-xs text-neutral-500">Acceso a métricas del sistema completo.</div>
                </div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-xl p-5 flex items-start gap-3">
                <div class="text-2xl">🔒</div>
                <div>
                    <div class="font-semibold text-[#0f172a] mb-1">Acceso protegido</div>
                    <div class="text-xs text-neutral-500">Las rutas admin están protegidas por middleware.</div>
                </div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-xl p-5 flex items-start gap-3">
                <div class="text-2xl">📋</div>
                <div>
                    <div class="font-semibold text-[#0f172a] mb-1">Sin actividad deportiva</div>
                    <div class="text-xs text-neutral-500">Los admins no registran rutinas ni entrenamientos.</div>
                </div>
            </div>
        </div>

    @else
        {{-- ===== VISTA PARA UN USUARIO NORMAL ===== --}}

        <h2 class="text-lg font-semibold text-[#0f172a] mb-3">Actividad del usuario</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-neutral-200 rounded-xl p-5">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Rutinas</div>
                <div class="text-3xl font-bold text-[#0f172a]">{{ $estadisticas['rutinas'] }}</div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-xl p-5">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Ejercicios</div>
                <div class="text-3xl font-bold text-[#0f172a]">{{ $estadisticas['ejercicios'] }}</div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-xl p-5">
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Entrenos totales</div>
                <div class="text-3xl font-bold text-[#0f172a]">{{ $estadisticas['entrenamientos'] }}</div>
            </div>

            <div class="bg-[#facc15] border border-[#eab308] rounded-xl p-5">
                <div class="text-xs font-medium text-[#854d0e] uppercase tracking-wider mb-1">Este mes</div>
                <div class="text-3xl font-bold text-[#0f172a]">{{ $estadisticas['entrenamientosMes'] }}</div>
            </div>
        </div>

        @if ($estadisticas['primerEntreno'] || $estadisticas['ultimoEntreno'])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                @if ($estadisticas['primerEntreno'])
                    <div class="bg-white border border-neutral-200 rounded-xl p-5">
                        <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Primer entrenamiento</div>
                        <div class="text-lg font-bold text-[#0f172a]">
                            {{ $estadisticas['primerEntreno']->format('d/m/Y') }}
                        </div>
                        <div class="text-xs text-neutral-500 mt-1">
                            Hace {{ (int) floor($estadisticas['primerEntreno']->diffInDays(now())) }} días
                        </div>
                    </div>
                @endif

                @if ($estadisticas['ultimoEntreno'])
                    <div class="bg-white border border-neutral-200 rounded-xl p-5">
                        <div class="text-xs font-medium text-neutral-500 uppercase tracking-wider mb-1">Último entrenamiento</div>
                        <div class="text-lg font-bold text-[#0f172a]">
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
            <h2 class="text-lg font-semibold text-[#0f172a] mb-3">Entrenamientos por mes</h2>
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
                                <td class="px-6 py-3 text-sm text-[#0f172a] capitalize font-medium">
                                    {{ $meses[$registro->mes - 1] }} {{ $registro->anyo }}
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <span class="inline-block bg-[#facc15]/20 text-[#854d0e] text-xs px-2.5 py-1 rounded-full font-semibold">
                                        {{ $registro->total }} {{ $registro->total === 1 ? 'sesión' : 'sesiones' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <h2 class="text-lg font-semibold text-[#0f172a] mb-3">Últimos entrenamientos</h2>
        <div class="bg-white border border-neutral-200 rounded-2xl shadow-sm overflow-hidden">
            @if ($ultimosEntrenamientos->isEmpty())
                <div class="p-8 text-center text-neutral-400 text-sm italic">
                    Este usuario aún no ha registrado entrenamientos.
                </div>
            @else
                <div class="divide-y divide-neutral-100">
                    @foreach ($ultimosEntrenamientos as $ent)
                        <div class="flex items-center justify-between p-5">
                            <div>
                                <div class="font-medium text-[#0f172a]">
                                    {{ $ent->fecha_entrenamiento->format('d/m/Y') }}
                                    <span class="text-xs text-neutral-400 ml-2 capitalize">
                                        {{ $ent->fecha_entrenamiento->locale('es')->isoFormat('dddd') }}
                                    </span>
                                </div>
                                <div class="text-xs text-neutral-500 mt-1">
                                    @if ($ent->rutina)
                                        <span class="bg-[#facc15]/20 text-[#854d0e] px-2 py-0.5 rounded-full font-medium">
                                            {{ $ent->rutina->nombre }}
                                        </span>
                                    @else
                                        <span class="italic">Sin rutina</span>
                                    @endif
                                    ·
                                    {{ $ent->detalles()->count() }} {{ $ent->detalles()->count() === 1 ? 'ejercicio' : 'ejercicios' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    @endif

</div>
@endsection
