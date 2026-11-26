@extends('layouts.panel')

@section('titulo', 'PideYa - Solicitud de repartidor')

@section('contenido')
<div class="mx-auto max-w-2xl space-y-6">

    @if ($repartidor->dni)
        <div class="space-y-2 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Tu solicitud está en revisión</h1>
            <p class="text-gray-600 dark:text-gray-300">
                Recibimos tus datos y documentos. Un administrador los revisará y, cuando seas aprobado,
                podrás empezar a recibir pedidos.
            </p>
        </div>
    @else
        <form method="POST" action="{{ route('solicitud.guardar') }}" enctype="multipart/form-data"
              class="space-y-4 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
            @csrf
            <div>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Completa tu solicitud</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Para ser repartidor necesitamos estos datos y documentos.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium dark:text-gray-300">DNI (13 dígitos)</label>
                    <input type="text" name="dni" value="{{ old('dni') }}" maxlength="13" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    @error('dni') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium dark:text-gray-300">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    @error('fecha_nacimiento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Zona de trabajo</label>
                <select name="id_zona" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    @foreach ($ciudades as $ciudad)
                        <optgroup label="{{ $ciudad->nombre }}">
                            @foreach ($ciudad->zonas as $zona)
                                <option value="{{ $zona->id_zona }}" @selected(old('id_zona') == $zona->id_zona)>{{ $zona->nombre }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('id_zona') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium dark:text-gray-300">Tipo de vehículo</label>
                    <select name="tipo_vehiculo" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                        <option value="moto" @selected(old('tipo_vehiculo') == 'moto')>Moto</option>
                        <option value="carro" @selected(old('tipo_vehiculo') == 'carro')>Carro</option>
                        <option value="camioneta" @selected(old('tipo_vehiculo') == 'camioneta')>Camioneta</option>
                    </select>
                    @error('tipo_vehiculo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium dark:text-gray-300">Placa</label>
                    <input type="text" name="placa" value="{{ old('placa') }}" maxlength="15" required
                           class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    @error('placa') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium dark:text-gray-300">Marca</label>
                    <input type="text" name="marca" value="{{ old('marca') }}" maxlength="50"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium dark:text-gray-300">Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo') }}" maxlength="50"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium dark:text-gray-300">Foto del DNI</label>
                    <input type="file" name="foto_dni" accept="image/*" required class="w-full text-sm dark:text-gray-300">
                    @error('foto_dni') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium dark:text-gray-300">Foto de la licencia</label>
                    <input type="file" name="foto_licencia" accept="image/*" required class="w-full text-sm dark:text-gray-300">
                    @error('foto_licencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <button class="rounded-lg bg-[#459361] px-5 py-2 font-semibold text-white">Enviar solicitud</button>
        </form>
    @endif
</div>
@endsection
