<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comercio;

class ComercioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $comercios = Comercio::with('tipo:id_tipo_comercio,nombre')->select(['id_comercio','id_tipo_comercio','nombre','descripcion','logo','tiempo_promedio_min','costo_delivery_base','calificacion'])->where('estado_aprobacion','aprobado')->where('esta_activado',true);

        if($request->filled('tipo')){
            $comercios->where('id_tipo_comercio',$request->input('tipo'));
        }
        if($request->filled('buscar')){
            $comercios->where('nombre','like','%'.$request->input('buscar').'%');
        }
        return $comercios->orderBy('nombre')->paginate(12);
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    return Comercio::with('tipo:id_tipo_comercio,nombre')->select(['id_comercio','id_tipo_comercio','nombre','descripcion','logo','tiempo_promedio_min','costo_delivery_base','calificacion'])->where('estado_aprobacion','aprobado')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */

}
