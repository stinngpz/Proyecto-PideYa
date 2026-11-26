@extends(auth()->user()->rol == 'cliente' ? 'layouts.cliente' : 'layouts.panel')

@section('titulo', 'PideYa - Soporte')

@section('contenido')
<div class="mx-auto max-w-2xl space-y-4">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Soporte</h1>
    <p class="text-gray-700 dark:text-gray-300">
        ¿Tienes un problema con tu pedido o tu cuenta? Escríbenos y te ayudamos.
    </p>
    <ul class="space-y-1 text-gray-700 dark:text-gray-300">
        <li>Correo: soporte@pideya.com</li>
        <li>Teléfono: 2200-0000</li>
        <li>Horario: todos los días de 8:00 a.m. a 10:00 p.m.</li>
    </ul>
</div>
@endsection