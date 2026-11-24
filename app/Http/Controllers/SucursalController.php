<?php

namespace App\Http\Controllers;

use App\Http\Requests\SucursalRequest;
use App\Models\Ciudad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    private function comercioDe(Request $request)
    {
        return $request->user()->comercio
            ?? abort(403, 'Tu cuenta no tiene un comercio registrado.');
    }

    public function index(Request $request)
    {
        $this->comercioDe($request);

        $ciudades = Ciudad::with('zonas')->where('activo', true)->orderBy('nombre')->get();

        return view('comercio.sucursales', ['ciudades' => $ciudades]);
    }

    public function lista(Request $request)
    {
        $sucursales = $this->comercioDe($request)
            ->sucursales()
            ->with('zona.ciudad')
            ->orderByDesc('id_sucursal')
            ->get();

        return response()->json($sucursales);
    }

    public function store(SucursalRequest $request)
    {
        $sucursal = $this->comercioDe($request)->sucursales()->create($request->validated());

        return response()->json($sucursal->load('zona.ciudad'), 201);
    }

    public function cambiarEstado(Request $request, int $id)
    {
        $sucursal = $this->comercioDe($request)->sucursales()->findOrFail($id);
        $sucursal->update(['esta_activa' => !$sucursal->esta_activa]);

        return response()->json(['esta_activa' => $sucursal->esta_activa]);
    }

    public function destroy(Request $request, int $id)
    {
        $sucursal = $this->comercioDe($request)->sucursales()->findOrFail($id);

        try {
            $sucursal->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'No se puede eliminar: la sucursal tiene pedidos asociados. Desactívala en su lugar.',
            ], 409);
        }

        return response()->json(['ok' => true]);
    }
}