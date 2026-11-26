@extends(auth()->user()->rol == 'cliente' ? 'layouts.cliente' : 'layouts.panel')

@section('titulo', 'PideYa - Información personal')

@section('contenido')
<div class="mx-auto max-w-2xl space-y-6" x-data="{ modal: @js(old('modal')) }">

    <a href="{{ route('cuenta') }}" class="inline-block text-sm font-semibold text-[#459361]">‹ Mi cuenta</a>

    @if (session('exito'))
        <div class="rounded-lg bg-green-50 p-3 text-sm text-green-800">{{ session('exito') }}</div>
    @endif

    <div class="text-center">
        <div class="mx-auto flex size-20 items-center justify-center rounded-full bg-[#459361] text-2xl font-bold text-white">
            {{ strtoupper(substr($usuario->nombre, 0, 1) . substr($usuario->apellido, 0, 1)) }}
        </div>
        <h1 class="mt-3 text-xl font-semibold text-gray-800 dark:text-white">{{ $usuario->nombre }} {{ $usuario->apellido }}</h1>
        <p class="text-sm text-gray-500">{{ $usuario->correo }}</p>
    </div>

    <div>
        <h2 class="mb-2 font-semibold text-gray-800 dark:text-white">Información personal</h2>

        <div class="divide-y divide-gray-200 rounded-2xl bg-white shadow dark:divide-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between p-4">
                <div>
                    <p class="font-medium text-gray-800 dark:text-white">Mis datos personales</p>
                    <p class="text-sm text-gray-500">Nombre, apellido y RTN</p>
                </div>
                <button type="button" @click="modal = 'datos'" class="text-sm font-semibold text-[#459361]">Editar</button>
            </div>

            <div class="flex items-center justify-between p-4">
                <div>
                    <p class="font-medium text-gray-800 dark:text-white">Teléfono</p>
                    <p class="text-sm text-gray-500">{{ $usuario->telefono }}</p>
                </div>
                <button type="button" @click="modal = 'telefono'" class="text-sm font-semibold text-[#459361]">Editar</button>
            </div>

            <div class="flex items-center justify-between p-4">
                <div>
                    <p class="font-medium text-gray-800 dark:text-white">Correo</p>
                    <p class="text-sm text-gray-500">{{ $usuario->correo }}</p>
                </div>
                <button type="button" @click="modal = 'correo'" class="text-sm font-semibold text-[#459361]">Editar</button>
            </div>

            <div class="flex items-center justify-between p-4">
                <div>
                    <p class="font-medium text-gray-800 dark:text-white">Contraseña</p>
                    <p class="text-sm text-gray-500">••••••••</p>
                </div>
                <button type="button" @click="modal = 'password'" class="text-sm font-semibold text-[#459361]">Cambiar</button>
            </div>
        </div>
    </div>

    @if ($usuario->rol == 'repartidor' && $usuario->repartidor)
        <div>
            <h2 class="mb-2 font-semibold text-gray-800 dark:text-white">Datos de repartidor</h2>
            <div class="divide-y divide-gray-200 rounded-2xl bg-white shadow dark:divide-gray-700 dark:bg-gray-800">
                <div class="p-4">
                    <p class="font-medium text-gray-800 dark:text-white">DNI</p>
                    <p class="text-sm text-gray-500">{{ $usuario->repartidor->dni ?? 'Sin enviar' }}</p>
                </div>
                <div class="p-4">
                    <p class="font-medium text-gray-800 dark:text-white">Fecha de nacimiento</p>
                    <p class="text-sm text-gray-500">{{ $usuario->repartidor->fecha_nacimiento ?? 'Sin enviar' }}</p>
                </div>
                <div class="flex items-center justify-between p-4">
                    <div>
                        <p class="font-medium text-gray-800 dark:text-white">Zona y vehículo</p>
                        <p class="text-sm text-gray-500">
                            {{ $usuario->repartidor->zona->nombre ?? 'Sin zona' }}
                            @if ($usuario->repartidor->vehiculos->first())
                                · {{ ucfirst($usuario->repartidor->vehiculos->first()->tipo_vehiculo) }} {{ $usuario->repartidor->vehiculos->first()->placa }}
                            @endif
                        </p>
                    </div>
                    @if ($usuario->repartidor->estado_aprobacion == 'aprobado')
                        <a href="{{ route('vehiculo') }}" class="text-sm font-semibold text-[#459361]">Cambiar</a>
                    @endif
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">El DNI y la fecha de nacimiento ya fueron revisados. Si alguno está mal, escribe a soporte.</p>
        </div>
    @endif

    @if ($usuario->rol == 'comercio' && $usuario->comercio)
        <div>
            <h2 class="mb-2 font-semibold text-gray-800 dark:text-white">Datos del negocio</h2>
            <div class="divide-y divide-gray-200 rounded-2xl bg-white shadow dark:divide-gray-700 dark:bg-gray-800">
                <div class="p-4">
                    <p class="font-medium text-gray-800 dark:text-white">Nombre del negocio</p>
                    <p class="text-sm text-gray-500">{{ $usuario->comercio->nombre }}</p>
                </div>
                <div class="p-4">
                    <p class="font-medium text-gray-800 dark:text-white">RTN del negocio</p>
                    <p class="text-sm text-gray-500">{{ $usuario->comercio->rtn }}</p>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">Estos datos ya fueron revisados. Si alguno está mal, escribe a soporte.</p>
        </div>
    @endif

    {{-- Modal: datos personales --}}
    <div x-show="modal === 'datos'" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 p-4">
        <form method="POST" action="{{ route('perfil.actualizar') }}" @click.outside="modal = null"
              class="w-full max-w-md space-y-4 rounded-2xl bg-white p-6 dark:bg-gray-800">
            @csrf
            @method('PUT')
            <input type="hidden" name="modal" value="datos">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Mis datos personales</h3>

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
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">RTN para facturas (14 dígitos, opcional)</label>
                <input type="text" name="rtn_para_sar" value="{{ old('rtn_para_sar', $usuario->rtn_para_sar) }}" maxlength="14"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('rtn_para_sar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" @click="modal = null" class="rounded-lg px-4 py-2 font-semibold text-gray-600 dark:text-gray-300">Cancelar</button>
                <button class="rounded-lg bg-[#459361] px-4 py-2 font-semibold text-white">Guardar</button>
            </div>
        </form>
    </div>

    {{-- Modal: teléfono --}}
    <div x-show="modal === 'telefono'" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 p-4">
        <form method="POST" action="{{ route('perfil.actualizar') }}" @click.outside="modal = null"
              class="w-full max-w-md space-y-4 rounded-2xl bg-white p-6 dark:bg-gray-800">
            @csrf
            @method('PUT')
            <input type="hidden" name="modal" value="telefono">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Teléfono</h3>

            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Teléfono (8 dígitos)</label>
                <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" maxlength="8" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('telefono') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" @click="modal = null" class="rounded-lg px-4 py-2 font-semibold text-gray-600 dark:text-gray-300">Cancelar</button>
                <button class="rounded-lg bg-[#459361] px-4 py-2 font-semibold text-white">Guardar</button>
            </div>
        </form>
    </div>

    {{-- Modal: correo --}}
    <div x-show="modal === 'correo'" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 p-4">
        <form method="POST" action="{{ route('perfil.actualizar') }}" @click.outside="modal = null"
              class="w-full max-w-md space-y-4 rounded-2xl bg-white p-6 dark:bg-gray-800">
            @csrf
            @method('PUT')
            <input type="hidden" name="modal" value="correo">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Correo</h3>

            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Correo nuevo</label>
                <input type="email" name="correo" value="{{ old('correo', $usuario->correo) }}" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('correo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium dark:text-gray-300">Contraseña actual</label>
                <input type="password" name="password_actual" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('password_actual') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" @click="modal = null" class="rounded-lg px-4 py-2 font-semibold text-gray-600 dark:text-gray-300">Cancelar</button>
                <button class="rounded-lg bg-[#459361] px-4 py-2 font-semibold text-white">Guardar</button>
            </div>
        </form>
    </div>

    {{-- Modal: contraseña --}}
    <div x-show="modal === 'password'" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 p-4">
        <form method="POST" action="{{ route('perfil.password') }}" @click.outside="modal = null"
              class="w-full max-w-md space-y-4 rounded-2xl bg-white p-6 dark:bg-gray-800">
            @csrf
            @method('PUT')
            <input type="hidden" name="modal" value="password">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Cambiar contraseña</h3>

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

            <div class="flex justify-end gap-3">
                <button type="button" @click="modal = null" class="rounded-lg px-4 py-2 font-semibold text-gray-600 dark:text-gray-300">Cancelar</button>
                <button class="rounded-lg bg-[#459361] px-4 py-2 font-semibold text-white">Cambiar contraseña</button>
            </div>
        </form>
    </div>
</div>
@endsection
