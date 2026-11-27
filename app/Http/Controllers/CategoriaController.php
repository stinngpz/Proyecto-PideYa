<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('departamento')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(15);

        // cambiar el nombre de la vista index si es necesario
        // return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        $departamentos = Departamento::orderBy('orden')
            ->orderBy('nombre')
            ->get();

        // cambiar el nombre de esta vista tambien si es necesario
        // return view('categorias.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_departamento' => ['required', 'integer', 'exists:departamentos,id_departamento'],
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('categorias', 'nombre')->where(
                    fn ($query) => $query->where('id_departamento', $request->input('id_departamento'))
                ),
            ],
            'orden' => ['nullable', 'integer'],
        ]);

        $validated['orden'] = $validated['orden'] ?? 0;

        $categoria = Categoria::create($validated);

        return redirect()
            ->route('categorias.edit', $categoria)
            ->with('success', 'Categoría registrada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        $departamentos = Departamento::orderBy('orden')
            ->orderBy('nombre')
            ->get();

        // cambiar esta vista tambien fijarse en el nombre y descomentar
        // return view('categorias.edit', compact('categoria', 'departamentos'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $idDepartamento = $request->input('id_departamento', $categoria->id_departamento);

        $validated = $request->validate([
            'id_departamento' => ['required', 'integer', 'exists:departamentos,id_departamento'],
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('categorias', 'nombre')
                    ->where(fn ($query) => $query->where('id_departamento', $idDepartamento))
                    ->ignore($categoria->id_categoria, 'id_categoria'),
            ],
            'orden' => ['nullable', 'integer'],
        ]);

        $validated['orden'] = $validated['orden'] ?? 0;

        $categoria->update($validated);

        return redirect()
            ->route('categorias.edit', $categoria)
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}