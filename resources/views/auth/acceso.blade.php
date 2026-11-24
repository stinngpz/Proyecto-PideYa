<!DOCTYPE html>
<html lang="es" class="h-full bg-[#F0E7E2]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PideYa - Acceso</title>
    @vite(['resources/css/panel.css', 'resources/js/panel.js'])
</head>
<body class="flex min-h-full items-center justify-center p-4">
<div class="w-full max-w-md rounded-2xl bg-white p-6 shadow"
    x-data="{ tab: @js(old('rol') ? 'registro' : 'login'), rol: @js(old('rol', 'cliente')) }">

    <a href="/cliente" class="mb-4 block text-center text-3xl font-bold text-[#022c22]">PideYa</a>

    @if (session('info'))
        <div class="mb-4 rounded-lg bg-blue-50 p-3 text-sm text-blue-800">{{ session('info') }}</div>
    @endif

    <div class="mb-5 grid grid-cols-2 rounded-lg bg-gray-100 p-1 text-sm font-semibold">
        <button type="button" @click="tab = 'login'"
                :class="tab === 'login' ? 'bg-white shadow' : 'text-gray-500'"
                class="rounded-md py-2">Iniciar sesión</button>
        <button type="button" @click="tab = 'registro'"
                :class="tab === 'registro' ? 'bg-white shadow' : 'text-gray-500'"
                class="rounded-md py-2">Crear cuenta</button>
    </div>

    {{-- LOGIN --}}
    <form x-show="tab === 'login'" method="POST" action="{{ route('login.post') }}" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-medium">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
            @if (!old('rol'))
                @error('correo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            @endif
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Contraseña</label>
            <input type="password" name="password" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="recordar"> Recordarme
        </label>
        <button class="w-full rounded-lg bg-[#459361] py-2 font-semibold text-white">Entrar</button>
    </form>

    {{-- REGISTRO --}}
    <form x-show="tab === 'registro'" x-cloak method="POST" action="{{ route('registro.post') }}" class="space-y-3">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-medium">Tipo de cuenta</label>
            <select name="rol" x-model="rol" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                <option value="cliente"    @selected(old('rol') === 'cliente')>Cliente</option>
                <option value="comercio"   @selected(old('rol') === 'comercio')>Comercio afiliado</option>
                <option value="repartidor" @selected(old('rol') === 'repartidor')>Repartidor</option>
            </select>
            @error('rol') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div x-show="rol === 'comercio'" x-cloak class="space-y-3">
    <div>
        <label class="mb-1 block text-sm font-medium">Nombre del negocio</label>
        <input type="text" name="nombre_negocio" value="{{ old('nombre_negocio') }}" maxlength="120"
               class="w-full rounded-lg border border-gray-300 px-3 py-2">
        @error('nombre_negocio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">RTN del negocio (14 dígitos)</label>
        <input type="text" name="rtn" value="{{ old('rtn') }}" maxlength="14"
               class="w-full rounded-lg border border-gray-300 px-3 py-2">
        @error('rtn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Tipo de comercio</label>
        <select name="id_tipo_comercio" class="w-full rounded-lg border border-gray-300 px-3 py-2">
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id_tipo_comercio }}" @selected((int) old('id_tipo_comercio') === $tipo->id_tipo_comercio)>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_tipo_comercio')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Descripción del negocio</label>
            <textarea name="descripcion" rows="3" maxlength="500"
                class="w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('descripcion') }}</textarea>
            @error('descripcion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="mb-1 block text-sm font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('nombre') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Apellido</label>
                <input type="text" name="apellido" value="{{ old('apellido') }}" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('apellido') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Correo</label>
            <input type="email" name="correo" value="{{ old('rol') ? old('correo') : '' }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
            @if (old('rol'))
                @error('correo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            @endif
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Teléfono (8 dígitos)</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
            @error('telefono') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Contraseña</label>
            <input type="password" name="password" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" required
                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
        </div>

        <button class="w-full rounded-lg bg-[#022c22] py-2 font-semibold text-white">Registrarme</button>
    </form>
</div>
</body>
</html>