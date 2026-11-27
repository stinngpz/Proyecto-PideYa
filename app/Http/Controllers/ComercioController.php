<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\TipoComercio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ComercioController extends Controller
{
    public function index()
    {
        $comercios = Comercio::with(['usuario', 'tipo'])
            ->orderByDesc('id_comercio')
            ->paginate(15);

        // cambiar el nombre de la vista index si es necesario
        // return view('comercios.index', compact('comercios'));
    }

    public function create()
    {
        $usuarios = User::orderBy('nombre')->get();
        $tiposComercio = TipoComercio::orderBy('nombre')->get();

        // cambiar el nombre de esta vista tambien si es necesario
        // return view('comercios.create', compact('usuarios', 'tiposComercio'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_usuario' => ['required', 'integer', 'exists:usuarios,id_usuario'],
            'id_tipo_comercio' => ['required', 'integer', 'exists:tipos_comercio,id_tipo_comercio'],
            'nombre' => ['required', 'string', 'max:120'],
            'rtn' => ['required', 'string', 'size:14'],
            'descripcion' => ['required', 'string'],
            'logo' => ['nullable', 'string', 'max:255'],
            'banner' => ['nullable', 'string', 'max:255'],
            'tiempo_promedio_min' => ['nullable', 'integer', 'min:1'],
            'costo_delivery_base' => ['nullable', 'numeric', 'min:0'],
            'porcentaje_comision' => ['nullable', 'numeric', 'between:0,100'],
            'estado_aprobacion' => ['nullable', Rule::in(['pendiente', 'aprobado', 'rechazado', 'suspendido'])],
            'esta_activado' => ['nullable', 'boolean'],
            'calificacion' => ['nullable', 'numeric', 'between:0,5'],
        ]);

        $validated['tiempo_promedio_min'] = $validated['tiempo_promedio_min'] ?? 30;
        $validated['costo_delivery_base'] = $validated['costo_delivery_base'] ?? 0;
        $validated['porcentaje_comision'] = $validated['porcentaje_comision'] ?? 15.00;
        $validated['estado_aprobacion'] = $validated['estado_aprobacion'] ?? 'pendiente';
        $validated['esta_activado'] = $validated['esta_activado'] ?? true;
        $validated['calificacion'] = $validated['calificacion'] ?? 0;

        $comercio = Comercio::create($validated);

        return redirect()
            ->route('comercios.edit', $comercio)
            ->with('success', 'Comercio registrado correctamente.');
    }

    public function show(Comercio $comercio)
    {
        return redirect()->route('comercios.edit', $comercio);
    }

    public function edit(Comercio $comercio)
    {
        $usuarios = User::orderBy('nombre')->get();
        $tiposComercio = TipoComercio::orderBy('nombre')->get();

        // cambiar esta vista tambien fijarse en el nombre y descomentar
        // return view('comercios.edit', compact('comercio', 'usuarios', 'tiposComercio'));
    }

    public function update(Request $request, Comercio $comercio)
    {
        $validated = $request->validate([
            'id_usuario' => ['required', 'integer', 'exists:usuarios,id_usuario'],
            'id_tipo_comercio' => ['required', 'integer', 'exists:tipos_comercio,id_tipo_comercio'],
            'nombre' => ['required', 'string', 'max:120'],
            'rtn' => ['required', 'string', 'size:14'],
            'descripcion' => ['required', 'string'],
            'logo' => ['nullable', 'string', 'max:255'],
            'banner' => ['nullable', 'string', 'max:255'],
            'tiempo_promedio_min' => ['nullable', 'integer', 'min:1'],
            'costo_delivery_base' => ['nullable', 'numeric', 'min:0'],
            'porcentaje_comision' => ['nullable', 'numeric', 'between:0,100'],
            'estado_aprobacion' => ['required', Rule::in(['pendiente', 'aprobado', 'rechazado', 'suspendido'])],
            'esta_activado' => ['nullable', 'boolean'],
            'calificacion' => ['nullable', 'numeric', 'between:0,5'],
        ]);

        $validated['tiempo_promedio_min'] = $validated['tiempo_promedio_min'] ?? 30;
        $validated['costo_delivery_base'] = $validated['costo_delivery_base'] ?? 0;
        $validated['porcentaje_comision'] = $validated['porcentaje_comision'] ?? 15.00;
        $validated['esta_activado'] = $validated['esta_activado'] ?? $comercio->esta_activado;
        $validated['calificacion'] = $validated['calificacion'] ?? 0;

        $comercio->update($validated);

        return redirect()
            ->route('comercios.edit', $comercio)
            ->with('success', 'Comercio actualizado correctamente.');
    }

    public function destroy(Comercio $comercio)
    {
        $comercio->delete();

        return redirect()
            ->route('comercios.index')
            ->with('success', 'Comercio eliminado correctamente.');
    }
}