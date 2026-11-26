<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SolicitudController;

Route::get('/', fn () => redirect('/cliente'));

Route::view('/cliente', 'cliente.inicio');
Route::view('/prueba', 'prueba');

    Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'formulario'])->name('login');
    Route::post('/login', [AuthController::class, 'ingresar'])->name('login.post');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.post');
});

    Route::middleware(['auth', 'sincache'])->group(function () {
    Route::get('/panel', [AuthController::class, 'panel'])->name('panel');
    Route::post('/logout', [AuthController::class, 'salir'])->name('logout');

    Route::view('/cuenta', 'cliente.cuenta')->name('cuenta');
    Route::get('/perfil', [PerfilController::class, 'editar'])->name('perfil');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
    Route::put('/perfil/password', [PerfilController::class, 'cambiarPassword'])->name('perfil.password');
    Route::view('/soporte', 'cliente.soporte')->name('soporte');
});

    Route::middleware(['auth', 'sincache', 'rol:cliente'])->prefix('direcciones')->name('direcciones.')->group(function () {
    Route::get('/', [DireccionController::class, 'index'])->name('index');
    Route::get('/lista', [DireccionController::class, 'lista'])->name('lista');
    Route::post('/', [DireccionController::class, 'store'])->name('store');
    Route::patch('/{id}/predeterminar', [DireccionController::class, 'predeterminar'])->name('predeterminar');
    Route::delete('/{id}', [DireccionController::class, 'destroy'])->name('destroy');
});

    Route::middleware(['auth', 'sincache', 'rol:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'tablero'])->name('admin.tablero');
});

Route::middleware(['auth', 'sincache', 'rol:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::patch('/usuarios/{id}/activo', [AdminController::class, 'alternarUsuario'])->name('usuarios.activo');

    Route::get('/comercios', [AdminController::class, 'comercios'])->name('comercios');
    Route::patch('/comercios/{id}/estado', [AdminController::class, 'estadoComercio'])->name('comercios.estado');

    Route::get('/repartidores', [AdminController::class, 'repartidores'])->name('repartidores');
    Route::patch('/repartidores/{id}/estado', [AdminController::class, 'estadoRepartidor'])->name('repartidores.estado');

    Route::get('/comisiones', [AdminController::class, 'comisiones'])->name('comisiones');
    Route::patch('/comisiones/{id}', [AdminController::class, 'actualizarComision'])->name('comisiones.actualizar');
});

Route::middleware(['auth', 'sincache', 'rol:comercio'])->group(function () {
    Route::view('/comercio', 'comercio.tablero', ['rol' => 'comercio']);

    Route::prefix('comercio/sucursales')->name('sucursales.')->group(function () {
        Route::get('/', [SucursalController::class, 'index'])->name('index');
        Route::get('/lista', [SucursalController::class, 'lista'])->name('lista');
        Route::post('/', [SucursalController::class, 'store'])->name('store');
        Route::patch('/{id}/estado', [SucursalController::class, 'cambiarEstado'])->name('estado');
        Route::delete('/{id}', [SucursalController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'sincache', 'rol:repartidor'])->group(function () {
    Route::get('/repartidor/solicitud', [SolicitudController::class, 'editar'])->name('solicitud');
    Route::post('/repartidor/solicitud', [SolicitudController::class, 'guardar'])->name('solicitud.guardar');
});

Route::middleware(['auth', 'sincache', 'rol:repartidor', 'aprobado'])->group(function () {
    Route::view('/repartidor', 'repartidor.tablero', ['rol' => 'repartidor']);

    Route::get('/repartidor/vehiculo', [VehiculoController::class, 'editar'])->name('vehiculo');
    Route::put('/repartidor/vehiculo', [VehiculoController::class, 'actualizar'])->name('vehiculo.actualizar');
});