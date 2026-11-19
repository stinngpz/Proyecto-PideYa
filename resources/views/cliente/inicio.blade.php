@extends('layouts.cliente')

@section('titulo', 'PideYa')

@section('portada')
    <section class="bg-[#022c22] text-white dark:bg-gray-950">
        <div class="px-6 pt-16 pb-32">
            <p class="text-sm font-semibold text-[#76BB20]">DELIVERY MULTICOMERCIO</p>

            <h1 class="mt-3 text-5xl font-bold leading-tight">
                Lo que se te antoja,<br>
                <span class="text-[#76BB20]">en minutos.</span>
            </h1>

            <p class="mt-4 max-w-md text-gray-300">
                Comida, súper, farmacia y más. Pide a tus comercios favoritos y sigue tu pedido hasta tu puerta.
            </p>
        </div>
    </section>
@endsection

@section('contenido')
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Categorías</h2>
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Restaurantes</h2>
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Contenido vario</h2>
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Ofertas</h2>
@endsection
