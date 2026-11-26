<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudRequest;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    public function editar(Request $request)
    {
        $repartidor = $request->user()->repartidor;

        if ($repartidor->estado_aprobacion == 'aprobado') {
            return redirect('/repartidor');
        }

        return view('repartidor.solicitud', [
            'repartidor' => $repartidor,
            'ciudades'   => Ciudad::with('zonas')->where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function guardar(SolicitudRequest $request)
    {
        $repartidor = $request->user()->repartidor;
        $datos = $request->validated();

        if ($repartidor->dni) {
            return redirect()->route('solicitud');
        }

        DB::transaction(function () use ($repartidor, $datos, $request) {
            $repartidor->update([
                'dni'              => $datos['dni'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
                'id_zona'          => $datos['id_zona'],
                'foto_dni'         => $request->file('foto_dni')->store('repartidores', 'public'),
                'foto_licencia'    => $request->file('foto_licencia')->store('repartidores', 'public'),
            ]);

            $repartidor->vehiculos()->create([
                'tipo_vehiculo' => $datos['tipo_vehiculo'],
                'placa'         => strtoupper($datos['placa']),
                'marca'         => $datos['marca'] ?? null,
                'modelo'        => $datos['modelo'] ?? null,
            ]);
        });

        return redirect()->route('solicitud');
    }
}
