<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::orderBy('orden')
            ->orderBy('nombre')
            ->paginate(15);

        // cambiar el nombre de la vista index si es necesario
        // return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        // cambiar el nombre de esta vista tambien si es necesario
        // return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:120', 'unique:departamentos,nombre'],
            'icono' => ['nullable', 'string', 'max:255'],
            'orden' => ['nullable', 'integer'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['orden'] = $validated['orden'] ?? 0;
        $validated['activo'] = $validated['activo'] ?? true;

        $departamento = Departamento::create($validated);

        return redirect()
            ->route('departamentos.edit', $departamento)
            ->with('success', 'Departamento registrado correctamente.');
    }

    public function show(Departamento $departamento)
    {
        return redirect()->route('departamentos.edit', $departamento);
    }

    public function edit(Departamento $departamento)
    {
        // cambiar esta vista tambien fijarse en el nombre y descomentar
        // return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('departamentos', 'nombre')->ignore($departamento->id_departamento, 'id_departamento'),
            ],
            'icono' => ['nullable', 'string', 'max:255'],
            'orden' => ['nullable', 'integer'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $validated['orden'] = $validated['orden'] ?? 0;
        $validated['activo'] = $validated['activo'] ?? $departamento->activo;

        $departamento->update($validated);

        return redirect()
            ->route('departamentos.edit', $departamento)
            ->with('success', 'Departamento actualizado correctamente.');
    }

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();

        return redirect()
            ->route('departamentos.index')
            ->with('success', 'Departamento eliminado correctamente.');
    }
}