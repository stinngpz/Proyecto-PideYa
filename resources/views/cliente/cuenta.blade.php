@extends('layouts.cliente')

@section('titulo', 'PideYa - Configuración de cuenta')

@section('contenido')
<div class="mx-auto max-w-2xl space-y-8">

    @if (session('exito'))
        <div class="rounded-lg bg-green-50 p-3 text-sm text-green-800">{{ session('exito') }}</div>
    @endif

    <form method="POST" action="{{ route('perfil.password') }}"
          class="space-y-4 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
        @csrf
        @method('PUT')
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Configuración de cuenta</h1>
        <h2 class="text-sm font-medium text-gray-500">Cambiar contraseña</h2>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Contraseña actual</label>
            <input type="password" name="password_actual" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
            @error('password_actual') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Nueva contraseña</label>
            <input type="password" name="password" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>

        <button class="rounded-lg bg-[#022c22] px-5 py-2 font-semibold text-white">Actualizar contraseña</button>
    </form>
</div>
@endsection