<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/cliente');
});

Route::view('/prueba', 'prueba');
Route::view('/cliente', 'cliente.inicio');
Route::view('/admin', 'admin.tablero', ['rol' => 'admin']);
Route::view('/comercio', 'comercio.tablero', ['rol' => 'comercio']);
Route::view('/repartidor', 'repartidor.tablero', ['rol' => 'repartidor']);
Route::post('/logout', function () {
    return redirect('/');
})->name('logout');
