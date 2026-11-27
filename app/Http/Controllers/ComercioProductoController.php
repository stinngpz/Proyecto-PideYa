<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\ComercioProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ComercioProductoController extends Controller
{
    public function index()
    {
        $comercioProductos = ComercioProducto::with(['comercio', 'producto'])
            ->orderByDesc('id_comercio_producto')
            ->paginate(15);

        // cambiar el nombre de la vista index si es necesario
        // return view('comercio_productos.index', compact('comercioProductos'));
    }

    public function create()
    {
        $comercios = Comercio::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();

        // cambiar el nombre de esta vista tambien si es necesario
        // return view('comercio_productos.create', compact('comercios', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_comercio' => ['required', 'integer', 'exists:comercios,id_comercio'],
            'id_producto' => [
                'required',
                'integer',
                'exists:productos,id_producto',
                Rule::unique('comercio_productos', 'id_producto')->where(function ($query) use ($request) {
                    return $query->where('id_comercio', $request->input('id_comercio'));
                }),
            ],
            'precio' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'string', 'max:255'],
            'esta_disponible' => ['nullable', 'boolean'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['esta_disponible'] = $validated['esta_disponible'] ?? true;

        $comercioProducto = ComercioProducto::create($validated);

        return redirect()
            ->route('comercio-productos.edit', $comercioProducto)
            ->with('success', 'Producto asignado al comercio correctamente.');
    }

    public function show(ComercioProducto $comercioProducto)
    {
        return redirect()->route('comercio-productos.edit', $comercioProducto);
    }

    public function edit(ComercioProducto $comercioProducto)
    {
        $comercios = Comercio::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();

        // cambiar esta vista tambien fijarse en el nombre y descomentar
        // return view('comercio_productos.edit', compact('comercioProducto', 'comercios', 'productos'));
    }

    public function update(Request $request, ComercioProducto $comercioProducto)
    {
        $comercioId = $request->input('id_comercio', $comercioProducto->id_comercio);

        $validated = $request->validate([
            'id_comercio' => ['required', 'integer', 'exists:comercios,id_comercio'],
            'id_producto' => [
                'required',
                'integer',
                'exists:productos,id_producto',
                Rule::unique('comercio_productos', 'id_producto')
                    ->where(function ($query) use ($comercioId) {
                        return $query->where('id_comercio', $comercioId);
                    })
                    ->ignore($comercioProducto->id_comercio_producto, 'id_comercio_producto'),
            ],
            'precio' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'string', 'max:255'],
            'esta_disponible' => ['nullable', 'boolean'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['esta_disponible'] = $validated['esta_disponible'] ?? $comercioProducto->esta_disponible;

        $comercioProducto->update($validated);

        return redirect()
            ->route('comercio-productos.edit', $comercioProducto)
            ->with('success', 'Producto del comercio actualizado correctamente.');
    }

    public function destroy(ComercioProducto $comercioProducto)
    {
        $comercioProducto->delete();

        return redirect()
            ->route('comercio-productos.index')
            ->with('success', 'Producto eliminado del comercio correctamente.');
    }
}