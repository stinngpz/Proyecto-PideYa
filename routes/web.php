<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\DetallePedidoOpcionController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\ComercioProductoController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\CategoriaController;

Route::get('/', fn () => redirect('/cliente'));

Route::view('/cliente', 'cliente.inicio');
Route::view('/prueba', 'prueba');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'formulario'])->name('login');
    Route::post('/login', [AuthController::class, 'ingresar'])->name('login.post');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/panel', [AuthController::class, 'panel'])->name('panel');
    Route::post('/logout', [AuthController::class, 'salir'])->name('logout');

    Route::get('/perfil', [PerfilController::class, 'editar'])->name('perfil');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
    Route::get('/cuenta', [PerfilController::class, 'cuenta'])->name('cuenta');
    Route::put('/perfil/password', [PerfilController::class, 'cambiarPassword'])->name('perfil.password');
    Route::view('/soporte', 'cliente.soporte')->name('soporte');
});

Route::middleware(['auth', 'rol:cliente'])->prefix('direcciones')->name('direcciones.')->group(function () {
    Route::get('/', [DireccionController::class, 'index'])->name('index');
    Route::get('/lista', [DireccionController::class, 'lista'])->name('lista');
    Route::post('/', [DireccionController::class, 'store'])->name('store');
    Route::patch('/{id}/predeterminar', [DireccionController::class, 'predeterminar'])->name('predeterminar');
    Route::delete('/{id}', [DireccionController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'rol:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'tablero'])->name('admin.tablero');
});

Route::middleware(['auth', 'rol:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::patch('/usuarios/{id}/activo', [AdminController::class, 'alternarUsuario'])->name('usuarios.activo');

    Route::get('/comercios', [AdminController::class, 'comercios'])->name('comercios');
    Route::patch('/comercios/{id}/estado', [AdminController::class, 'estadoComercio'])->name('comercios.estado');

    Route::get('/repartidores', [AdminController::class, 'repartidores'])->name('repartidores');
    Route::patch('/repartidores/{id}/estado', [AdminController::class, 'estadoRepartidor'])->name('repartidores.estado');

    Route::get('/comisiones', [AdminController::class, 'comisiones'])->name('comisiones');
    Route::patch('/comisiones/{id}', [AdminController::class, 'actualizarComision'])->name('comisiones.actualizar');
});

Route::middleware(['auth', 'rol:comercio'])->group(function () {
    Route::view('/comercio', 'comercio.tablero', ['rol' => 'comercio']);

    Route::prefix('comercio/sucursales')->name('sucursales.')->group(function () {
        Route::get('/', [SucursalController::class, 'index'])->name('index');
        Route::get('/lista', [SucursalController::class, 'lista'])->name('lista');
        Route::post('/', [SucursalController::class, 'store'])->name('store');
        Route::patch('/{id}/estado', [SucursalController::class, 'cambiarEstado'])->name('estado');
        Route::delete('/{id}', [SucursalController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'rol:repartidor'])->group(function () {
    Route::view('/repartidor', 'repartidor.tablero', ['rol' => 'repartidor']);

    Route::get('/repartidor/vehiculo', [VehiculoController::class, 'editar'])->name('vehiculo');
    Route::put('/repartidor/vehiculo', [VehiculoController::class, 'actualizar'])->name('vehiculo.actualizar');
});

Route::prefix('pedidos')->name('pedidos.')->group(function () {
    Route::get('/', [PedidoController::class, 'index'])->name('index');
    Route::get('/crear', [PedidoController::class, 'create'])->name('create');
    Route::post('/', [PedidoController::class, 'store'])->name('store');
    Route::get('/{pedido}', [PedidoController::class, 'show'])->name('show');
    Route::get('/{pedido}/editar', [PedidoController::class, 'edit'])->name('edit');
    Route::put('/{pedido}', [PedidoController::class, 'update'])->name('update');
    Route::delete('/{pedido}', [PedidoController::class, 'destroy'])->name('destroy');
});

Route::prefix('detalle-pedido')->name('detalle-pedido.')->group(function () {
    Route::get('/', [DetallePedidoController::class, 'index'])->name('index');
    Route::get('/crear', [DetallePedidoController::class, 'create'])->name('create');
    Route::post('/', [DetallePedidoController::class, 'store'])->name('store');
    Route::get('/{detallePedido}', [DetallePedidoController::class, 'show'])->name('show');
    Route::get('/{detallePedido}/editar', [DetallePedidoController::class, 'edit'])->name('edit');
    Route::put('/{detallePedido}', [DetallePedidoController::class, 'update'])->name('update');
    Route::delete('/{detallePedido}', [DetallePedidoController::class, 'destroy'])->name('destroy');
});

Route::prefix('detalle-pedido-opciones')->name('detalle-pedido-opciones.')->group(function () {
    Route::get('/', [DetallePedidoOpcionController::class, 'index'])->name('index');
    Route::get('/crear', [DetallePedidoOpcionController::class, 'create'])->name('create');
    Route::post('/', [DetallePedidoOpcionController::class, 'store'])->name('store');
    Route::get('/{id_detalle}/{id_opcion}', [DetallePedidoOpcionController::class, 'show'])->name('show');
    Route::get('/{id_detalle}/{id_opcion}/editar', [DetallePedidoOpcionController::class, 'edit'])->name('edit');
    Route::put('/{id_detalle}/{id_opcion}', [DetallePedidoOpcionController::class, 'update'])->name('update');
    Route::delete('/{id_detalle}/{id_opcion}', [DetallePedidoOpcionController::class, 'destroy'])->name('destroy');
});

Route::prefix('gestion-comercios')->name('comercios.')->group(function () {
    Route::get('/', [ComercioController::class, 'index'])->name('index');
    Route::get('/crear', [ComercioController::class, 'create'])->name('create');
    Route::post('/', [ComercioController::class, 'store'])->name('store');
    Route::get('/{comercio}', [ComercioController::class, 'show'])->name('show');
    Route::get('/{comercio}/editar', [ComercioController::class, 'edit'])->name('edit');
    Route::put('/{comercio}', [ComercioController::class, 'update'])->name('update');
    Route::delete('/{comercio}', [ComercioController::class, 'destroy'])->name('destroy');
});

Route::prefix('comercio-productos')->name('comercio-productos.')->group(function () {
    Route::get('/', [ComercioProductoController::class, 'index'])->name('index');
    Route::get('/crear', [ComercioProductoController::class, 'create'])->name('create');
    Route::post('/', [ComercioProductoController::class, 'store'])->name('store');
    Route::get('/{comercioProducto}', [ComercioProductoController::class, 'show'])->name('show');
    Route::get('/{comercioProducto}/editar', [ComercioProductoController::class, 'edit'])->name('edit');
    Route::put('/{comercioProducto}', [ComercioProductoController::class, 'update'])->name('update');
    Route::delete('/{comercioProducto}', [ComercioProductoController::class, 'destroy'])->name('destroy');
});

Route::prefix('ciudades')->name('ciudades.')->group(function () {
    Route::get('/', [CiudadController::class, 'index'])->name('index');
    Route::get('/crear', [CiudadController::class, 'create'])->name('create');
    Route::post('/', [CiudadController::class, 'store'])->name('store');
    Route::get('/{ciudad}', [CiudadController::class, 'show'])->name('show');
    Route::get('/{ciudad}/editar', [CiudadController::class, 'edit'])->name('edit');
    Route::put('/{ciudad}', [CiudadController::class, 'update'])->name('update');
    Route::delete('/{ciudad}', [CiudadController::class, 'destroy'])->name('destroy');
});

Route::prefix('departamentos')->name('departamentos.')->group(function () {
    Route::get('/', [DepartamentoController::class, 'index'])->name('index');
    Route::get('/crear', [DepartamentoController::class, 'create'])->name('create');
    Route::post('/', [DepartamentoController::class, 'store'])->name('store');
    Route::get('/{departamento}', [DepartamentoController::class, 'show'])->name('show');
    Route::get('/{departamento}/editar', [DepartamentoController::class, 'edit'])->name('edit');
    Route::put('/{departamento}', [DepartamentoController::class, 'update'])->name('update');
    Route::delete('/{departamento}', [DepartamentoController::class, 'destroy'])->name('destroy');
});

Route::prefix('categorias')->name('categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/crear', [CategoriaController::class, 'create'])->name('create');
    Route::post('/', [CategoriaController::class, 'store'])->name('store');
    Route::get('/{categoria}/editar', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
});