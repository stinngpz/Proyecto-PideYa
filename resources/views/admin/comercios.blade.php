@extends('layouts.panel')

@section('titulo', 'PideYa - Aprobación de comercios')

@section('contenido')
<div class="space-y-4">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Aprobación de comercios</h1>

    <form method="GET" class="flex gap-3">
        <select name="estado" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <option value="">Todos los estados</option>
            @foreach (['pendiente', 'aprobado', 'rechazado', 'suspendido'] as $estado)
                <option value="{{ $estado }}" @selected(request('estado') === $estado)>{{ ucfirst($estado) }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-[#022c22] px-4 py-2 text-sm font-semibold text-white">Filtrar</button>
    </form>

    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
        <table class="w-full text-left text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-50 text-xs uppercase dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-3">Negocio</th>
                    <th class="px-4 py-3">RTN</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Responsable</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Cuenta</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comercios as $c)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-3">
                            <p class="font-semibold">{{ $c->nombre }}</p>
                            <p class="text-xs text-gray-500">{{ $c->descripcion }}</p>
                        </td>
                        <td class="px-4 py-3">{{ $c->rtn }}</td>
                        <td class="px-4 py-3">{{ $c->tipo?->nombre }}</td>
                        <td class="px-4 py-3">
                            {{ $c->usuario?->nombre }} {{ $c->usuario?->apellido }}
                            <p class="text-xs text-gray-500">{{ $c->usuario?->correo }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span data-campo="estado" class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold dark:bg-gray-700">{{ ucfirst($c->estado_aprobacion) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span data-campo="cuenta">{{ $c->usuario?->activo ? 'Activa' : 'Inactiva' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3 font-semibold">
                                <button type="button" data-accion data-cuerpo='{"estado":"aprobado"}'
                                        data-url="{{ route('admin.comercios.estado', $c->id_comercio) }}"
                                        class="text-[#459361]">Aprobar</button>
                                <button type="button" data-accion data-cuerpo='{"estado":"rechazado"}'
                                        data-confirmar="¿Rechazar este comercio?"
                                        data-url="{{ route('admin.comercios.estado', $c->id_comercio) }}"
                                        class="text-red-600">Rechazar</button>
                                <button type="button" data-accion data-cuerpo='{"estado":"suspendido"}'
                                        data-confirmar="¿Suspender este comercio?"
                                        data-url="{{ route('admin.comercios.estado', $c->id_comercio) }}"
                                        class="text-gray-600 dark:text-gray-300">Suspender</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay comercios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300">
        <span>Página {{ $comercios->currentPage() }} de {{ $comercios->lastPage() }}</span>
        <div class="flex gap-4">
            @if ($comercios->previousPageUrl())
                <a href="{{ $comercios->previousPageUrl() }}" class="font-semibold text-[#459361]">Anterior</a>
            @endif
            @if ($comercios->nextPageUrl())
                <a href="{{ $comercios->nextPageUrl() }}" class="font-semibold text-[#459361]">Siguiente</a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.acciones')
@endpush