<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comercio;
use App\Models\Ciudad;

class CiudadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Ciudad::with('zonas:id_zona,id_ciudad,nombre')->select(['id_ciudad', 'nombre'])->where('activo', true)->orderBy('nombre')->get();
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       return Ciudad::with('zonas')->findOrFail($id);
    }

  
}
