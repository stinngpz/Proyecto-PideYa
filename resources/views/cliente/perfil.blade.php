@extends('layouts.cliente')

@section('titulo', 'PideYa - Mi perfil')

@section('contenido')
<div class="mx-auto max-w-2xl space-y-8">

    @if (session('exito'))
        <div class="rounded-lg bg-green-50 p-3 text-sm text-green-800">{{ session('exito') }}</div>
    @endif

    {{-- DATOS PERSONALES --}}
    <form method="POST" action="{{ route('perfil.actualizar') }}"
          class="space-y-4 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
        @csrf
        @method('PUT')
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Mis datos</h1>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('nombre') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Apellido</label>
                <input type="text" name="apellido" value="{{ old('apellido', $usuario->apellido) }}" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('apellido') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Correo (no editable)</label>
            <input type="email" value="{{ $usuario->correo }}" disabled
                   class="w-full rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-gray-500">
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Teléfono (8 dígitos)</label>
                <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('telefono') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">RTN para facturas (14 dígitos)</label>
                <input type="text" name="rtn_para_sar" value="{{ old('rtn_para_sar', $usuario->rtn_para_sar) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('rtn_para_sar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <button class="rounded-lg bg-[#459361] px-5 py-2 font-semibold text-white">Guardar cambios</button>
    </form>
</div>
@endsection