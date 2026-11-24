<?php

namespace App\Http\Controllers;

use App\Http\Requests\DireccionRequest;
use App\Models\Ciudad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DireccionController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::with('zonas')->where('activo', true)->orderBy('nombre')->get();

        return view('cliente.direcciones', ['ciudades' => $ciudades]);
    }

    public function lista(Request $request)
    {
        $direcciones = $request->user()
            ->direcciones()
            ->with('zona.ciudad')
            ->orderByDesc('es_predeterminada')
            ->orderByDesc('id_direccion')
            ->get();

        return response()->json($direcciones);
    }

    public function store(DireccionRequest $request)
    {
        $usuario = $request->user();
        $datos = $request->validated();
        $datos['es_predeterminada'] = !$usuario->direcciones()->exists()
            || $request->boolean('es_predeterminada');

        $direccion = DB::transaction(function () use ($usuario, $datos) {
            if ($datos['es_predeterminada']) {
                $usuario->direcciones()->update(['es_predeterminada' => false]);
            }

            return $usuario->direcciones()->create($datos);
        });

        return response()->json($direccion->load('zona.ciudad'), 201);
    }

    public function predeterminar(Request $request, int $id)
    {
        $usuario = $request->user();
        $direccion = $usuario->direcciones()->findOrFail($id);

        DB::transaction(function () use ($usuario, $direccion) {
            $usuario->direcciones()->update(['es_predeterminada' => false]);
            $direccion->update(['es_predeterminada' => true]);
        });

        return response()->json(['ok' => true]);
    }

    public function destroy(Request $request, int $id)
    {
        $usuario = $request->user();
        $direccion = $usuario->direcciones()->findOrFail($id);
        $eraPredeterminada = $direccion->es_predeterminada;

        try {
            $direccion->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'No se puede eliminar: esta dirección está asociada a pedidos.',
            ], 409);
        }

        if ($eraPredeterminada) {
            $usuario->direcciones()->orderBy('id_direccion')->first()?->update(['es_predeterminada' => true]);
        }

        return response()->json(['ok' => true]);
    }
}