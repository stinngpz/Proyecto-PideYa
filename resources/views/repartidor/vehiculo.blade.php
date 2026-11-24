@extends('layouts.panel')

@section('titulo', 'PideYa - Mi vehículo')

@section('contenido')
<div class="mx-auto max-w-2xl space-y-6">

    @if (session('exito'))
        <div class="rounded-lg bg-green-50 p-3 text-sm text-green-800">{{ session('exito') }}</div>
    @endif

    <form method="POST" action="{{ route('vehiculo.actualizar') }}"
          class="space-y-4 rounded-2xl bg-white p-6 shadow dark:bg-gray-800">
        @csrf
        @method('PUT')
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Mi vehículo y zona de trabajo</h1>

        <div>
            <label class="mb-1 block text-sm font-medium dark:text-gray-300">Zona de trabajo</label>
            <select name="id_zona" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @foreach ($ciudades as $ciudad)
                    <optgroup label="{{ $ciudad->nombre }}">
                        @foreach ($ciudad->zonas as $zona)
                            <option value="{{ $zona->id_zona }}"
                                @selected((int) old('id_zona', $repartidor->id_zona) === $zona->id_zona)>
                                {{ $zona->nombre }}
                            </option>
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
                    @foreach (['moto' => 'Moto', 'carro' => 'Carro', 'camioneta' => 'Camioneta'] as $valor => $texto)
                        <option value="{{ $valor }}"
                            @selected(old('tipo_vehiculo', $vehiculo?->tipo_vehiculo ?? 'moto') === $valor)>
                            {{ $texto }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_vehiculo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Placa</label>
                <input type="text" name="placa" maxlength="15" required
                       value="{{ old('placa', $vehiculo?->placa) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('placa') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Marca</label>
                <input type="text" name="marca" maxlength="50"
                       value="{{ old('marca', $vehiculo?->marca) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('marca') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Modelo</label>
                <input type="text" name="modelo" maxlength="50"
                       value="{{ old('modelo', $vehiculo?->modelo) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('modelo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <button class="rounded-lg bg-[#459361] px-5 py-2 font-semibold text-white">Guardar</button>
    </form>
</div>
@endsection