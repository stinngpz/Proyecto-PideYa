<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PideYa - @yield('titulo')</title>
    @vite(['resources/css/panel.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-[#F0E7E2] p-6">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 text-center shadow">
        <p class="text-2xl font-bold text-[#022c22]">PideYa</p>
        <p class="mt-6 text-6xl font-bold text-[#459361]">@yield('codigo')</p>
        <h1 class="mt-4 text-xl font-semibold text-gray-800">@yield('titulo')</h1>
        <p class="mt-2 text-gray-600">@yield('mensaje')</p>
        <a href="/" class="mt-6 inline-block rounded-lg bg-[#459361] px-5 py-2 font-semibold text-white">Volver al inicio</a>
    </div>
</body>
</html>
