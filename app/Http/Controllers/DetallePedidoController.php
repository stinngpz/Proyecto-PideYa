<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\ComercioProducto;
use App\Models\DetallePedido;
use App\Models\Oferta;
use App\Models\Pedido;
use Illuminate\Http\Request;

class DetallePedidoController extends Controller
{
    public function index()
    {
        $detalles = DetallePedido::with(['pedido', 'comercio', 'comercioProducto', 'oferta'])
            ->orderByDesc('id_detalle')
            ->paginate(15);

        // cambiar el nombre de la vista index si es necesariooo
        // return view('detalle_pedido.index', compact('detalles'));
    }

    public function create()
    {
        $pedidos = Pedido::orderByDesc('id_pedido')->get();
        $comercios = Comercio::orderBy('nombre')->get();
        $productos = ComercioProducto::orderBy('id_comercio_producto')->get();
        $ofertas = Oferta::orderByDesc('id_oferta')->get();

        // cambiar el nombre de esta vista tambien si es necesario
        // return view('detalle_pedido.create', compact('pedidos', 'comercios', 'productos', 'ofertas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pedido' => ['required', 'integer', 'exists:pedidos,id_pedido'],
            'id_comercio' => ['required', 'integer', 'exists:comercios,id_comercio'],
            'id_comercio_producto' => ['required', 'integer', 'exists:comercio_productos,id_comercio_producto'],
            'id_oferta' => ['nullable', 'integer', 'exists:ofertas,id_oferta'],
            'nombre_producto' => ['required', 'string', 'max:120'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'precio_normal' => ['required', 'numeric', 'min:0'],
            'precio_oferta' => ['nullable', 'numeric', 'min:0'],
            'subtotal_linea' => ['required', 'numeric', 'min:0'],
            'notas_comercio' => ['nullable', 'string', 'max:255'],
        ]);

        $detalle = DetallePedido::create($validated);

        return redirect()
            ->route('detalle-pedido.edit', $detalle)
            ->with('success', 'Detalle de pedido agregado correctamente.');
    }

    public function show(DetallePedido $detallePedido)
    {
        return redirect()->route('detalle-pedido.edit', $detallePedido);
    }

    public function edit(DetallePedido $detallePedido)
    {
        $pedidos = Pedido::orderByDesc('id_pedido')->get();
        $comercios = Comercio::orderBy('nombre')->get();
        $productos = ComercioProducto::orderBy('id_comercio_producto')->get();
        $ofertas = Oferta::orderByDesc('id_oferta')->get();

        // cambiar esta vista tambien fijarse en el nombre y descomentar
        // return view('detalle_pedido.edit', compact('detallePedido', 'pedidos', 'comercios', 'productos', 'ofertas'));
    }

    public function update(Request $request, DetallePedido $detallePedido)
    {
        $validated = $request->validate([
            'id_pedido' => ['required', 'integer', 'exists:pedidos,id_pedido'],
            'id_comercio' => ['required', 'integer', 'exists:comercios,id_comercio'],
            'id_comercio_producto' => ['required', 'integer', 'exists:comercio_productos,id_comercio_producto'],
            'id_oferta' => ['nullable', 'integer', 'exists:ofertas,id_oferta'],
            'nombre_producto' => ['required', 'string', 'max:120'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'precio_normal' => ['required', 'numeric', 'min:0'],
            'precio_oferta' => ['nullable', 'numeric', 'min:0'],
            'subtotal_linea' => ['required', 'numeric', 'min:0'],
            'notas_comercio' => ['nullable', 'string', 'max:255'],
        ]);

        $detallePedido->update($validated);

        return redirect()
            ->route('detalle-pedido.edit', $detallePedido)
            ->with('success', 'Detalle de pedido actualizado correctamente.');
    }

    public function destroy(DetallePedido $detallePedido)
    {
        $detallePedido->delete();

        return redirect()
            ->route('detalle-pedido.index')
            ->with('success', 'Detalle de pedido eliminado correctamente.');
    }
}