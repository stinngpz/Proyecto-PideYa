<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Direccion;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'comercio', 'sucursal', 'estado'])
            ->orderByDesc('id_pedido')
            ->paginate(15);

        // cambiar el nombre de la vista index si es necesario
        // return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = User::where('rol', 'cliente')->orderBy('nombre')->get();
        $comercios = Comercio::orderBy('nombre')->get();
        $sucursales = Sucursal::orderBy('nombre')->get();
        $direcciones = Direccion::orderBy('nombre')->get();
        $estados = EstadoPedido::orderBy('orden')->get();

        // cambiar el nombre de esta vista tambien si es necesario
        // return view('pedidos.create', compact('clientes', 'comercios', 'sucursales', 'direcciones', 'estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cliente' => 'required|exists:usuarios,id_usuario',
            'id_comercio' => 'required|exists:comercios,id_comercio',
            'id_sucursal' => [
                'required',
                Rule::exists('sucursales', 'id_sucursal')->where(function ($query) use ($request) {
                    return $query->where('id_comercio', $request->input('id_comercio'));
                }),
            ],
            'id_direccion' => 'nullable|exists:direcciones,id_direccion',
            'id_estado' => 'nullable|exists:estados_pedido,id_estado',
            'latitud_entrega' => 'required|numeric|between:-90,90',
            'longitud_entrega' => 'required|numeric|between:-180,180',
            'direccion_entrega' => 'required|string|max:255',
            'instrucciones_entrega' => 'nullable|string|max:255',
            'distancia_km' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'tarifa_envio' => 'required|numeric|min:0',
            'pago_repartidor' => 'nullable|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'base_gravada' => 'required|numeric|min:0',
            'isv' => 'required|numeric|min:0',
            'propina' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'eta_minutos' => 'nullable|integer|min:1',
            'motivo_cancelacion' => 'nullable|string|max:255',
            'fecha_creacion' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
        ]);

        $validated['id_estado'] = $validated['id_estado'] ?? 1;
        $validated['pago_repartidor'] = $validated['pago_repartidor'] ?? 0;
        $validated['descuento'] = $validated['descuento'] ?? 0;
        $validated['propina'] = $validated['propina'] ?? 0;
        $validated['fecha_creacion'] = $validated['fecha_creacion'] ?? now();

        Pedido::create($validated);

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido registrado correctamente.');
    }

    public function show(Pedido $pedido)
    {
        return redirect()->route('pedidos.edit', $pedido);
    }

    public function edit(Pedido $pedido)
    {
        $clientes = User::where('rol', 'cliente')->orderBy('nombre')->get();
        $comercios = Comercio::orderBy('nombre')->get();
        $sucursales = Sucursal::orderBy('nombre')->get();
        $direcciones = Direccion::orderBy('nombre')->get();
        $estados = EstadoPedido::orderBy('orden')->get();

        // cambiar esta vista tambien fijarse en el nombre y descomentar
        // return view('pedidos.edit', compact('pedido', 'clientes', 'comercios', 'sucursales', 'direcciones', 'estados'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $comercioId = $request->input('id_comercio', $pedido->id_comercio);

        $validated = $request->validate([
            'id_cliente' => 'required|exists:usuarios,id_usuario',
            'id_comercio' => 'required|exists:comercios,id_comercio',
            'id_sucursal' => [
                'required',
                Rule::exists('sucursales', 'id_sucursal')->where(function ($query) use ($comercioId) {
                    return $query->where('id_comercio', $comercioId);
                }),
            ],
            'id_direccion' => 'nullable|exists:direcciones,id_direccion',
            'id_estado' => 'required|exists:estados_pedido,id_estado',
            'latitud_entrega' => 'required|numeric|between:-90,90',
            'longitud_entrega' => 'required|numeric|between:-180,180',
            'direccion_entrega' => 'required|string|max:255',
            'instrucciones_entrega' => 'nullable|string|max:255',
            'distancia_km' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'tarifa_envio' => 'required|numeric|min:0',
            'pago_repartidor' => 'nullable|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'base_gravada' => 'required|numeric|min:0',
            'isv' => 'required|numeric|min:0',
            'propina' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'eta_minutos' => 'nullable|integer|min:1',
            'motivo_cancelacion' => 'nullable|string|max:255',
            'fecha_creacion' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
        ]);

        $validated['pago_repartidor'] = $validated['pago_repartidor'] ?? 0;
        $validated['descuento'] = $validated['descuento'] ?? 0;
        $validated['propina'] = $validated['propina'] ?? 0;

        $pedido->update($validated);

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }
}