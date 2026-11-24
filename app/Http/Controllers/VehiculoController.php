<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehiculoRequest;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculoController extends Controller
{
    private function repartidorDe(Request $request)
    {
        return $request->user()->repartidor
            ?? abort(403, 'Tu cuenta no tiene un perfil de repartidor.');
    }

    public function editar(Request $request)
    {
        $repartidor = $this->repartidorDe($request);

        return view('repartidor.vehiculo', [
            'repartidor' => $repartidor,
            'vehiculo'   => $repartidor->vehiculos()->first(),
            'ciudades'   => Ciudad::with('zonas')->where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function actualizar(VehiculoRequest $request)
    {
        $repartidor = $this->repartidorDe($request);
        $datos = $request->validated();

        DB::transaction(function () use ($repartidor, $datos) {
            $repartidor->update(['id_zona' => $datos['id_zona']]);

            $repartidor->vehiculos()->updateOrCreate([], [
                'placa'         => strtoupper($datos['placa']),
                'marca'         => $datos['marca'] ?? null,
                'modelo'        => $datos['modelo'] ?? null,
                'tipo_vehiculo' => $datos['tipo_vehiculo'],
            ]);
        });

        return back()->with('exito', 'Tus datos de reparto se guardaron correctamente.');
    }
}