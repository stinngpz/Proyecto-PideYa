<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoComercio;

class TipoComercioController extends Controller
{

    public function index()
    {
        return TipoComercio::select(['id_tipo_comercio', 'nombre'])->orderBy('nombre')->get();
    }

    public function show(string $id)
    {
        return TipoComercio::select(['id_tipo_comercio', 'nombre'])->findOrFail($id);
    }

}
