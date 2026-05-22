@extends('layouts.app')

@section('contenido')
<div class="max-w-6xl mx-auto">

    {{-- Cabecera --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.panel') }}" class="text-sm text-neutral-500 hover:text-[#0f172a] transition">
                ← Volver al panel
            </a>
            <h1 class="text-3xl font-bold text-[#0f172a] mt-2">Gestión de usuarios</h1>
            <p class="text-sm text-neutral-500 mt-1">
                {{ $totalGeneral }} {{ $totalGeneral === 1 ? 'usuario registrado' : 'usuarios registrados' }} en la plataforma.
            </p>
        </div>
        <a href="{{ route('admin.usuarios.crear') }}"
           class="bg-[#facc15] hover:bg-[#eab308] text-[#0f172a] font-semibold px-5 py-2.5 rounded-lg transition shadow-sm hover:shadow-md whitespace-nowrap">
            + Nuevo usuario
        </a>
    </div>

    {{-- Buscador y filtros --}}
    <div class="bg-white border border-neutral-200 rounded-2xl p-5 mb-4">
        <form method="GET" action="{{ route('admin.usuarios') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

            <div class="md:col-span-2">
                <label for="buscar" class="block text-xs font-semibold text-neutral-700 mb-1">Buscar por nombre o email</label>
                <input
                    id="buscar"
                    type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Ej: daniela o @volt.com"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none"
                >
            </div>

            <div>
                <label for="rol" class="block text-xs font-semibold text-neutral-700 mb-1">Rol</label>
                <select
                    id="rol"
                    name="rol"
                    class="w-full px-3 py-2 text-sm rounded-lg border border-neutral-300 focus:border-[#facc15] focus:ring-2 focus:ring-[#facc15]/20 transition outline-none bg-white"
                >
                    <option value="">Todos</option>
                    <option value="1" {{ request('rol') == '1' ? 'selected' : '' }}>Usuarios</option>
                    <option value="2" {{ request('rol') == '2' ? 'selected' : '' }}>Administradores</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="bg-[#0f172a] hover:bg-[#1e293b] text-white font-medium px-4 py-2 rounded-lg text-sm transition flex-1">
                    Filtrar
                </button>
                @if (request()->hasAny(['buscar', 'rol']))
                    <a href="{{ route('admin.usuarios') }}"
                       class="bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-medium px-4 py-2 rounded-lg text-sm transition">
                        Limpiar
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- Tabla --}}
    @if ($usuarios->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
            <p class="text-yellow-800 font-medium mb-2">
                @if (request()->hasAny(['buscar', 'rol']))
                    No se encontraron usuarios con esos filtros.
                @else
                    No hay usuarios registrados.
                @endif
            </p>
            @if (request()->hasAny(['buscar', 'rol']))
                <a href="{{ route('admin.usuarios') }}" class="text-sm text-yellow-700 underline hover:text-yellow-900">
                    Quitar filtros
                </a>
            @endif
        </div>
    @else
        <div class="bg-white border border-neutral-200 rounded-2xl overflow-hidden overflow-x-auto">
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
                                             class="w-10 h-10 rounded-full object-cover border {{ $u->rol_id === 2 ? 'border-[#facc15]' : 'border-neutral-200' }} {{ !$u->activo ? 'grayscale' : '' }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15]' : 'bg-[#facc15] text-[#0f172a]' }} flex items-center justify-center font-bold text-sm">
                                            {{ strtoupper(substr($u->nombre, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="font-medium text-[#0f172a]">{{ $u->nombre }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-600">
                                {{ $u->email }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                    {{ $u->rol_id === 2 ? 'bg-[#0f172a] text-[#facc15]' : 'bg-neutral-100 text-neutral-700' }}">
                                    {{ $u->rol->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($u->activo)
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-green-100 text-green-800 whitespace-nowrap">
                                        ✓ Activa
                                    </span>
                                @else
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-red-100 text-red-800 whitespace-nowrap">
                                        🚫 Bloqueada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-500 whitespace-nowrap">
                                {{ $u->fecha_creacion?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.usuarios.show', $u) }}"
                                       class="text-sm text-[#0f172a] hover:text-[#eab308] font-medium transition">
                                        Ver
                                    </a>

                                    @if ($u->id !== auth()->id())
                                        <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Seguro que quieres eliminar al usuario {{ $u->nombre }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-neutral-400 italic">Tú mismo/a</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>
    @endif

</div>
@endsection
