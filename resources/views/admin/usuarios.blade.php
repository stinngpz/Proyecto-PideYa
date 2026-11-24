@extends('layouts.panel')

@section('titulo', 'PideYa - Usuarios')

@section('contenido')
<div class="space-y-4">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Usuarios</h1>

    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre o correo"
               class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
        <select name="rol" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <option value="">Todos los roles</option>
            @foreach (['admin', 'comercio', 'repartidor', 'cliente'] as $rol)
                <option value="{{ $rol }}" @selected(request('rol') === $rol)>{{ ucfirst($rol) }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-[#022c22] px-4 py-2 text-sm font-semibold text-white">Filtrar</button>
    </form>

    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
        <table class="w-full text-left text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-50 text-xs uppercase dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Correo</th>
                    <th class="px-4 py-3">Teléfono</th>
                    <th class="px-4 py-3">Rol</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $u)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-3">{{ $u->nombre }} {{ $u->apellido }}</td>
                        <td class="px-4 py-3">{{ $u->correo }}</td>
                        <td class="px-4 py-3">{{ $u->telefono }}</td>
                        <td class="px-4 py-3">{{ ucfirst($u->rol) }}</td>
                        <td class="px-4 py-3">
                            <span data-campo="activo" class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold dark:bg-gray-700">{{ $u->activo ? 'Activo' : 'Inactivo' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if ((int) $u->id_usuario !== (int) auth()->user()->id_usuario)
                                <button type="button" data-accion data-campo="accion"
                                        data-url="{{ route('admin.usuarios.activo', $u->id_usuario) }}"
                                        class="font-semibold text-[#459361]">{{ $u->activo ? 'Desactivar' : 'Activar' }}</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay usuarios con esos filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300">
        <span>Página {{ $usuarios->currentPage() }} de {{ $usuarios->lastPage() }}</span>
        <div class="flex gap-4">
            @if ($usuarios->previousPageUrl())
                <a href="{{ $usuarios->previousPageUrl() }}" class="font-semibold text-[#459361]">Anterior</a>
            @endif
            @if ($usuarios->nextPageUrl())
                <a href="{{ $usuarios->nextPageUrl() }}" class="font-semibold text-[#459361]">Siguiente</a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.acciones')
@endpush