@extends(auth()->user()->rol == 'cliente' ? 'layouts.cliente' : 'layouts.panel')

@section('titulo', 'PideYa - Mi cuenta')

@section('contenido')
<div class="mx-auto max-w-2xl space-y-8">

    <h1 class="text-center text-xl font-semibold text-gray-800 dark:text-white">¡Hola, {{ auth()->user()->nombre }}!</h1>

    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('perfil') }}" class="text-center">
            <div class="flex h-20 items-center justify-center rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300">
                <x-svg.user-circle class="size-7" />
            </div>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Información personal</p>
        </a>
        <a href="{{ route('soporte') }}" class="text-center">
            <div class="flex h-20 items-center justify-center rounded-2xl bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300">
                <x-svg.info-circle class="size-7" />
            </div>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Soporte</p>
        </a>
    </div>

    @if (auth()->user()->rol != 'admin')
        <div>
            <h2 class="mb-2 text-lg font-semibold text-gray-800 dark:text-white">Perfil</h2>

            @if (auth()->user()->rol == 'cliente')
                <a href="{{ route('direcciones.index') }}" class="flex items-center justify-between rounded-lg px-3 py-4 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                    <span>Direcciones</span>
                    <span>›</span>
                </a>
            @endif

            @if (auth()->user()->rol == 'repartidor')
                <a href="{{ route('vehiculo') }}" class="flex items-center justify-between rounded-lg px-3 py-4 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                    <span>Mi vehículo y zona</span>
                    <span>›</span>
                </a>
            @endif

            @if (auth()->user()->rol == 'comercio')
                <a href="{{ route('sucursales.index') }}" class="flex items-center justify-between rounded-lg px-3 py-4 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                    <span>Sucursales</span>
                    <span>›</span>
                </a>
            @endif
        </div>
    @endif

    <div>
        <h2 class="mb-2 text-lg font-semibold text-gray-800 dark:text-white">Sesión</h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex w-full items-center justify-between rounded-lg px-3 py-4 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-800">
                <span>Cerrar sesión</span>
                <span>›</span>
            </button>
        </form>
    </div>
</div>
@endsection
