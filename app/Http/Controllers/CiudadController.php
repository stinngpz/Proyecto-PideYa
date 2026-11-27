<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::orderBy('nombre')
            ->paginate(15);

        // cambiar el nombre de la vista index si es necesario
        // return view('ciudades.index', compact('ciudades'));
    }

    public function create()
    {
        // cambiar el nombre de esta vista tambien si es necesario
        // return view('ciudades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:80'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        $ciudad = Ciudad::create($validated);

        return redirect()
            ->route('ciudades.edit', $ciudad)
            ->with('success', 'Ciudad registrada correctamente.');
    }

    public function show(Ciudad $ciudad)
    {
        return redirect()->route('ciudades.edit', $ciudad);
    }

    public function edit(Ciudad $ciudad)
    {
        // cambiar esta vista tambien fijarse en el nombre y descomentar
        // return view('ciudades.edit', compact('ciudad'));
    }

    public function update(Request $request, Ciudad $ciudad)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:80'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['activo'] = $validated['activo'] ?? $ciudad->activo;

        $ciudad->update($validated);

        return redirect()
            ->route('ciudades.edit', $ciudad)
            ->with('success', 'Ciudad actualizada correctamente.');
    }

    public function destroy(Ciudad $ciudad)
    {
        $ciudad->delete();

        return redirect()
            ->route('ciudades.index')
            ->with('success', 'Ciudad eliminada correctamente.');
    }
}