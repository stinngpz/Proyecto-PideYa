@extends('layouts.panel')

@section('titulo', 'PideYa - Administrador')

@section('contenido')
<div class="space-y-6">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Panel de control</h1>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('admin.comercios', ['estado' => 'aprobado']) }}"
           class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500">Comercios aprobados</p>
            <p class="mt-1 text-3xl font-bold text-gray-800 dark:text-white">{{ $comerciosAprobados }}</p>
            <p class="mt-1 text-xs text-gray-500">{{ $comerciosPendientes }} pendientes de aprobación</p>
        </a>

        <a href="{{ route('admin.repartidores') }}"
           class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500">Repartidores aprobados</p>
            <p class="mt-1 text-3xl font-bold text-gray-800 dark:text-white">{{ $repartidoresAprobados }}</p>
            <p class="mt-1 text-xs text-gray-500">{{ $repartidoresConectados }} conectados</p>
        </a>

        <a href="{{ route('admin.usuarios') }}"
           class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500">Usuarios registrados</p>
            <p class="mt-1 text-3xl font-bold text-gray-800 dark:text-white">{{ $usuariosTotal }}</p>
            <p class="mt-1 text-xs text-gray-500">{{ $usuariosInactivos }} inactivos</p>
        </a>

        <a href="{{ route('admin.comisiones') }}"
           class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm text-gray-500">Comisiones generadas</p>
            <p class="mt-1 text-3xl font-bold text-gray-800 dark:text-white">L {{ number_format($comisionesTotal, 2) }}</p>
            <p class="mt-1 text-xs text-gray-500">Ver detalle por comercio</p>
        </a>
    </div>
</div>
@endsection