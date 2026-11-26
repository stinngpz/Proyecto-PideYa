<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ComercioController;
use App\Http\Controllers\Api\CiudadController;
use App\Http\Controllers\Api\TipoComercioController;

Route::apiResource('comercios', ComercioController::class)->only(['index', 'show']);
Route::apiResource('ciudades', CiudadController::class)->only(['index', 'show']);
Route::apiResource('tipos-comercio',TipoComercioController::class)->only(['index', 'show']);