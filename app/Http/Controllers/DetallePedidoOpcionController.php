<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\DetallePedidoOpcion;
use App\Models\OpcionProducto;
use Illuminate\Http\Request;

class DetallePedidoOpcionController extends Controller
{
    public function index()
    {
        $opcionesDetalle = DetallePedidoOpcion::with(['detallePedido', 'opcionProducto'])
            ->orderByDesc('id_detalle')
            ->paginate(15);

        // VISTA INDEX: modificarla de acuerdo al nombre de la vista
        // return view('detalle_pedido_opciones.index', compact('opcionesDetalle'));
    }

    public function create()
    {
        $detalles = DetallePedido::orderByDesc('id_detalle')->get();
        $opciones = OpcionProducto::orderBy('id_opcion')->get();

        // VISTA CREATE: modifi arla de acuerdo al nombre 
        // return view('detalle_pedido_opciones.create', compact('detalles', 'opciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_detalle' => ['required', 'integer', 'exists:detalle_pedido,id_detalle'],
            'id_opcion' => ['required', 'integer', 'exists:opciones_producto,id_opcion'],
            'nombre_opcion' => ['required', 'string', 'max:120'],
            'precio_adicional' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['precio_adicional'] = $validated['precio_adicional'] ?? 0;

        DetallePedidoOpcion::create($validated);

        return redirect()
            ->route('detalle-pedido-opciones.index')
            ->with('success', 'Opción agregada al detalle de pedido correctamente.');
    }

    public function show(int $id_detalle, int $id_opcion)
    {
        return redirect()->route('detalle-pedido-opciones.edit', [
            'id_detalle' => $id_detalle,
            'id_opcion' => $id_opcion,
        ]);
    }

    public function edit(int $id_detalle, int $id_opcion)
    {
        $opcionDetalle = DetallePedidoOpcion::where('id_detalle', $id_detalle)
            ->where('id_opcion', $id_opcion)
            ->firstOrFail();

        $detalles = DetallePedido::orderByDesc('id_detalle')->get();
        $opciones = OpcionProducto::orderBy('id_opcion')->get();

        // VISTA EDIT: modificarla 
        // return view('detalle_pedido_opciones.edit', compact('opcionDetalle', 'detalles', 'opciones'));
    }

    public function update(Request $request, int $id_detalle, int $id_opcion)
    {
        $opcionDetalle = DetallePedidoOpcion::where('id_detalle', $id_detalle)
            ->where('id_opcion', $id_opcion)
            ->firstOrFail();

        $validated = $request->validate([
            'nombre_opcion' => ['required', 'string', 'max:120'],
            'precio_adicional' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['precio_adicional'] = $validated['precio_adicional'] ?? 0;

        $opcionDetalle->update($validated);

        return redirect()
            ->route('detalle-pedido-opciones.index')
            ->with('success', 'Opción del detalle actualizada correctamente.');
    }

    public function destroy(int $id_detalle, int $id_opcion)
    {
        $opcionDetalle = DetallePedidoOpcion::where('id_detalle', $id_detalle)
            ->where('id_opcion', $id_opcion)
            ->firstOrFail();

        $opcionDetalle->delete();

        return redirect()
            ->route('detalle-pedido-opciones.index')
            ->with('success', 'Opción eliminada del detalle correctamente.');
    }
}