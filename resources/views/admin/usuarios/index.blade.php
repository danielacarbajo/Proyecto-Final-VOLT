@extends('layouts.app')

@section('contenido')
<div class="max-w-7xl mx-auto">

    {{-- Botón Volver (PILL) --}}
    <div class="mb-6">
        <a href="{{ route('admin.panel') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-200 rounded-lg shadow-sm hover:shadow-md hover:border-neutral-300 transition text-sm font-medium text-neutral-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al panel
        </a>
    </div>

    {{-- Cabecera --}}
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="font-bebas text-4xl text-[#0f172a] tracking-wide pb-1">GESTIÓN DE USUARIOS</h1>
                <p class="text-sm text-neutral-500 mt-1">
                    Administra las cuentas registradas en VOLT.
                </p>
            </div>
            <a href="{{ route('admin.usuarios.crear') }}"
               class="bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold px-5 py-3 rounded-lg transition shadow-sm hover:shadow-md flex items-center justify-center gap-2 sm:whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo usuario
            </a>
        </div>
    </div>

    {{-- Mini resumen --}}
    @php
        $totalAdmins = $usuarios->where('rol_id', 2)->count();
        $totalUsuariosNormales = $usuarios->where('rol_id', 1)->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Total</div>
            </div>
            <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $totalGeneral }}</div>
        </div>

        <div class="bg-white border border-neutral-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-[#ffd600]/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#854d0e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="text-xs font-semibold text-neutral-500 uppercase tracking-wider">Usuarios</div>
            </div>
            <div class="font-bebas text-4xl text-[#0f172a] leading-tight pb-1">{{ $totalUsuariosNormales }}</div>
        </div>

        <div class="bg-[#0f172a] text-white border border-[#0f172a] rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-[#ffd600] flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="text-xs font-semibold text-[#ffd600] uppercase tracking-wider">Admins</div>
            </div>
            <div class="font-bebas text-4xl text-white leading-tight pb-1">{{ $totalAdmins }}</div>
        </div>
    </div>

    {{-- Buscador y filtros --}}
    <div class="bg-white border border-neutral-200 rounded-2xl p-5 mb-4 shadow-sm">
        <form method="GET" action="{{ route('admin.usuarios') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

            <div class="md:col-span-2">
                <label for="buscar" class="block text-xs font-semibold text-neutral-700 mb-1.5">Buscar por nombre o email</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="buscar" type="text" name="buscar" value="{{ request('buscar') }}"
                           placeholder="Ej: daniela o @volt.com"
                           class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none">
                </div>
            </div>

            <div>
                <label for="rol" class="block text-xs font-semibold text-neutral-700 mb-1.5">Rol</label>
                <select id="rol" name="rol"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-neutral-300 focus:border-[#ffd600] focus:ring-2 focus:ring-[#ffd600]/20 transition outline-none bg-white">
                    <option value="">Todos</option>
                    <option value="1" {{ request('rol') == '1' ? 'selected' : '' }}>Usuarios</option>
                    <option value="2" {{ request('rol') == '2' ? 'selected' : '' }}>Administradores</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="bg-[#0f172a] hover:bg-[#1e293b] text-white font-semibold px-4 py-2.5 rounded-lg text-sm transition flex-1">
                    Filtrar
                </button>
                @if (request()->hasAny(['buscar', 'rol']))
                    <a href="{{ route('admin.usuarios') }}"
                       class="bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium px-4 py-2.5 rounded-lg text-sm transition">
                        Limpiar
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- Lista --}}
    @if ($usuarios->isEmpty())
        <div class="bg-white border border-neutral-200 rounded-2xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="font-bebas text-2xl text-[#0f172a] mb-2">
                @if (request()->hasAny(['buscar', 'rol']))
                    SIN RESULTADOS
                @else
                    NO HAY USUARIOS
                @endif
            </h3>
            <p class="text-sm text-neutral-500 mb-4">
                @if (request()->hasAny(['buscar', 'rol']))
                    Prueba a cambiar los filtros aplicados.
                @else
                    Aún no hay usuarios registrados en la plataforma.
                @endif
            </p>
            @if (request()->hasAny(['buscar', 'rol']))
                <a href="{{ route('admin.usuarios') }}" class="inline-block text-sm text-[#0f172a] hover:underline font-medium">
                    Quitar filtros
                </a>
            @endif
        </div>
    @else

        {{-- MÓVIL: tarjetas --}}
        <div class="md:hidden space-y-3">
            @foreach ($usuarios as $u)
                <div class="bg-white border border-neutral-200 rounded-2xl p-4 shadow-sm {{ !$u->activo ? 'opacity-60' : '' }}">
                    <div class="flex items-center gap-3 mb-3">
                        @if ($u->foto)
                            <img src="{{ asset('storage/' . $u->foto) }}" alt="Avatar"
                                 class="w-12 h-12 rounded-full object-cover border-2 {{ $u->rol_id === 2 ? 'border-[#ffd600]' : 'border-neutral-200' }} flex-shrink-0 {{ !$u->activo ? 'grayscale' : '' }}">
                        @else
                            <div class="w-12 h-12 rounded-full flex-shrink-0 {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#ffd600] border-2 border-[#ffd600]' : 'bg-[#ffd600] text-[#0f172a]' }} flex items-center justify-center font-bold">
                                {{ strtoupper(substr($u->nombre, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <div class="font-semibold text-[#0f172a] truncate">{{ $u->nombre }}</div>
                            <div class="text-xs text-neutral-500 truncate">{{ $u->email }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap mb-3">
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-full
                            {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#ffd600]' : 'bg-neutral-100 text-neutral-700' }}">
                            {{ $u->rol->nombre }}
                        </span>
                        @if ($u->activo)
                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full bg-green-100 text-green-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Activa
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full bg-red-100 text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Bloqueada
                            </span>
                        @endif
                        <span class="text-[10px] text-neutral-500">
                            {{ $u->fecha_creacion?->format('d/m/Y') ?? '—' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2 pt-3 border-t border-neutral-100">
                        <a href="{{ route('admin.usuarios.show', $u) }}"
                           class="flex-1 text-center text-xs font-semibold bg-[#0f172a] hover:bg-[#1e293b] text-white px-3 py-2 rounded-lg transition flex items-center justify-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Ver detalle
                        </a>
                        @if ($u->id !== auth()->id())
                            <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST" class="form-eliminar inline" data-nombre="{{ $u->nombre }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="abrirModalEliminar(this)"
                                        class="w-9 h-9 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition"
                                        title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <span class="text-[10px] text-neutral-400 italic px-2">Tú</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- DESKTOP: tabla --}}
        <div class="hidden md:block bg-white border border-neutral-200 rounded-2xl overflow-hidden overflow-x-auto shadow-sm">
            <table class="w-full min-w-[800px]">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Usuario</th>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Email</th>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Rol</th>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Estado</th>
                        <th class="text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Registro</th>
                        <th class="text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @foreach ($usuarios as $u)
                        <tr class="hover:bg-neutral-50 transition {{ !$u->activo ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($u->foto)
                                        <img src="{{ asset('storage/' . $u->foto) }}" alt="Avatar"
                                             class="w-10 h-10 rounded-full object-cover border-2 {{ $u->rol_id === 2 ? 'border-[#ffd600]' : 'border-neutral-200' }} {{ !$u->activo ? 'grayscale' : '' }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#ffd600] border-2 border-[#ffd600]' : 'bg-[#ffd600] text-[#0f172a]' }} flex items-center justify-center font-bold text-sm">
                                            {{ strtoupper(substr($u->nombre, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="font-semibold text-[#0f172a]">{{ $u->nombre }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-600">{{ $u->email }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full
                                    {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#ffd600]' : 'bg-neutral-100 text-neutral-700' }}">
                                    {{ $u->rol->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($u->activo)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-800 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Activa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-800 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                        Bloqueada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-500 whitespace-nowrap">
                                {{ $u->fecha_creacion?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.usuarios.show', $u) }}"
                                       class="inline-flex items-center gap-1.5 text-xs font-semibold bg-[#0f172a] hover:bg-[#1e293b] text-white px-3 py-1.5 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver
                                    </a>
                                    @if ($u->id !== auth()->id())
                                        <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST" class="form-eliminar inline" data-nombre="{{ $u->nombre }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="abrirModalEliminar(this)"
                                                    class="inline-flex items-center justify-center w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" title="Eliminar usuario">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-neutral-400 italic">Tú</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

       {{-- Paginación --}}
        <div class="mt-4 bg-white border border-neutral-200 rounded-2xl p-4 shadow-sm">
            {{ $usuarios->links('vendor.pagination.volt') }}
        </div>
    @endif

</div>

{{-- Modal eliminación --}}
<div id="modal-eliminar" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-[#0f172a]/70 backdrop-blur-sm" onclick="cerrarModalEliminar()"></div>

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
                ¿Estás segura de que quieres eliminar al usuario <strong id="modal-nombre-usuario" class="text-[#0f172a]"></strong>?
            </p>
            <p class="text-xs text-neutral-500 mt-2">Se borrarán también todas sus rutinas, ejercicios y entrenamientos asociados.</p>
        </div>

        <div class="bg-neutral-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-neutral-100">
            <button type="button" onclick="cerrarModalEliminar()"
                    class="px-5 py-2.5 text-sm font-semibold text-neutral-700 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-100 transition">
                Cancelar
            </button>
            <button type="button" id="btn-confirmar-eliminar"
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
    let formAEliminar = null;

    function abrirModalEliminar(btn) {
        const form = btn.closest('.form-eliminar');
        formAEliminar = form;
        document.getElementById('modal-nombre-usuario').textContent = `"${form.dataset.nombre}"`;
        document.getElementById('modal-eliminar').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalEliminar() {
        document.getElementById('modal-eliminar').classList.add('hidden');
        document.body.style.overflow = '';
        formAEliminar = null;
    }

    document.getElementById('btn-confirmar-eliminar').addEventListener('click', () => {
        if (formAEliminar) formAEliminar.submit();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') cerrarModalEliminar();
    });
</script>

@endsection