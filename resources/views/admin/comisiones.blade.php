@extends('layouts.panel')

@section('titulo', 'PideYa - Comisiones')

@section('contenido')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Comisiones de la plataforma</h1>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500">Total generado</p>
            <p class="mt-1 text-3xl font-bold text-gray-800 dark:text-white">L {{ number_format($totalGenerado, 2) }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500">Pedidos con comisión</p>
            <p class="mt-1 text-3xl font-bold text-gray-800 dark:text-white">{{ $totalPedidos }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500">Porcentaje promedio cobrado</p>
            <p class="mt-1 text-3xl font-bold text-gray-800 dark:text-white">{{ number_format($promedio, 2) }}%</p>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
        <table class="w-full text-left text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-50 text-xs uppercase dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-3">Comercio</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Porcentaje vigente</th>
                    <th class="px-4 py-3">Pedidos</th>
                    <th class="px-4 py-3">Total generado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comercios as $c)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-3 font-semibold">{{ $c->nombre }}</td>
                        <td class="px-4 py-3">{{ ucfirst($c->estado_aprobacion) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <input type="number" name="porcentaje" min="0" max="100" step="0.01"
                                       value="{{ number_format((float) $c->porcentaje_comision, 2, '.', '') }}"
                                       class="w-24 rounded-lg border border-gray-300 px-2 py-1 text-sm">
                                <span>%</span>
                                <button type="button" data-guardar
                                        data-url="{{ route('admin.comisiones.actualizar', $c->id_comercio) }}"
                                        class="font-semibold text-[#459361]">Guardar</button>
                                <span data-mensaje class="text-xs"></span>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $c->comisiones_count }}</td>
                        <td class="px-4 py-3">L {{ number_format((float) ($c->comisiones_sum_monto_comision ?? 0), 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No hay comercios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p class="text-sm text-gray-500">
        Cambiar el porcentaje solo afecta a los pedidos futuros. Cada comisión ya generada conserva el porcentaje con el que se calculó.
    </p>
</div>
@endsection

@push('scripts')
<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;

document.querySelectorAll('[data-guardar]').forEach(function (boton) {
    boton.addEventListener('click', async function () {
        const fila = boton.closest('tr');
        const campo = fila.querySelector('input[name="porcentaje"]');
        const mensaje = fila.querySelector('[data-mensaje]');

        const respuesta = await fetch(boton.dataset.url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify({ porcentaje: campo.value }),
        });
        const datos = await respuesta.json().catch(function () { return {}; });

        if (!respuesta.ok) {
            const errores = datos.errors ? Object.values(datos.errors).flat().join(' ') : '';
            mensaje.textContent = errores || datos.message || 'No se pudo guardar.';
            mensaje.className = 'text-xs text-red-600';
            return;
        }

        campo.value = datos.porcentaje;
        mensaje.textContent = 'Guardado';
        mensaje.className = 'text-xs text-green-700';
    });
});
</script>
@endpush