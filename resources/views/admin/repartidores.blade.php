@extends('layouts.panel')

@section('titulo', 'PideYa - Aprobación de repartidores')

@section('contenido')
<div class="space-y-4">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Aprobación de repartidores</h1>

    <p id="aviso" class="mb-4 hidden rounded-lg bg-green-100 px-4 py-3 text-sm font-semibold text-green-800"></p>

    <form method="GET" class="flex gap-3">
        <select name="estado" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <option value="">Todos los estados</option>
            @foreach (['pendiente', 'aprobado', 'suspendido','rechazado'] as $estado)
                <option value="{{ $estado }}" @selected(request('estado') === $estado)>{{ ucfirst($estado) }}</option>
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
                    <th class="px-4 py-3">Zona</th>
                    <th class="px-4 py-3">Solicitud</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Cuenta</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($repartidores as $r)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-3">{{ $r->usuario?->nombre }} {{ $r->usuario?->apellido }}</td>
                        <td class="px-4 py-3">{{ $r->usuario?->correo }}</td>
                        <td class="px-4 py-3">{{ $r->usuario?->telefono }}</td>
                        <td class="px-4 py-3">{{ $r->zona?->nombre ?? 'Sin zona' }}</td>
                        <td class="px-4 py-3">
                            @if ($r->dni)
                                <p>DNI: {{ $r->dni }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ ucfirst($r->vehiculos->first()?->tipo_vehiculo) }} · {{ $r->vehiculos->first()?->placa }}
                                </p>
                                <div class="flex gap-2 text-xs font-semibold">
                                    <a href="{{ asset('storage/' . $r->foto_dni) }}" target="_blank" class="text-[#459361]">Ver DNI</a>
                                    <a href="{{ asset('storage/' . $r->foto_licencia) }}" target="_blank" class="text-[#459361]">Ver licencia</a>
                                </div>
                            @else
                                <span class="text-xs text-gray-500">Sin enviar</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span data-campo="estado" class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold dark:bg-gray-700">{{ ucfirst($r->estado_aprobacion) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span data-campo="cuenta">{{ $r->usuario?->activo ? 'Activa' : 'Inactiva' }}</span>
                        </td>
                        <td class="px-4 py-3">
                        <div class="flex gap-3 font-semibold">
                            @if ($r->estado_aprobacion == 'pendiente' && !$r->dni)
                                <span class="text-xs font-normal text-gray-500">Solicitud incompleta</span>
                            @endif

                            @if ($r->estado_aprobacion == 'pendiente' && $r->dni)
                                <button type="button" data-accion data-cuerpo='{"estado":"aprobado"}'
                                        data-url="{{ route('admin.repartidores.estado', $r->id_repartidor) }}"
                                        class="text-[#459361]">Aprobar</button>
                                <button type="button" data-accion data-cuerpo='{"estado":"rechazado"}'
                                        data-confirmar="¿Rechazar a este repartidor?"
                                        data-url="{{ route('admin.repartidores.estado', $r->id_repartidor) }}"
                                        class="text-red-600">Rechazar</button>
                            @endif

                            @if ($r->estado_aprobacion == 'aprobado')
                                <button type="button" data-accion data-cuerpo='{"estado":"suspendido"}'
                                        data-confirmar="¿Suspender a este repartidor?"
                                        data-url="{{ route('admin.repartidores.estado', $r->id_repartidor) }}"
                                        class="text-orange-600">Suspender</button>
                            @endif

                            @if ($r->estado_aprobacion == 'suspendido')
                                <button type="button" data-accion data-cuerpo='{"estado":"aprobado"}'
                                        data-url="{{ route('admin.repartidores.estado', $r->id_repartidor) }}"
                                        class="text-[#459361]">Reactivar</button>
                            @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No hay repartidores registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300">
        <span>Página {{ $repartidores->currentPage() }} de {{ $repartidores->lastPage() }}</span>
        <div class="flex gap-4">
            @if ($repartidores->previousPageUrl())
                <a href="{{ $repartidores->previousPageUrl() }}" class="font-semibold text-[#459361]">Anterior</a>
            @endif
            @if ($repartidores->nextPageUrl())
                <a href="{{ $repartidores->nextPageUrl() }}" class="font-semibold text-[#459361]">Siguiente</a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.acciones')
@endpush