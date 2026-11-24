<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Comision;
use App\Models\Repartidor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function tablero()
    {
        return view('admin.tablero', [
            'comerciosAprobados'     => Comercio::where('estado_aprobacion', 'aprobado')->count(),
            'comerciosPendientes'    => Comercio::where('estado_aprobacion', 'pendiente')->count(),
            'repartidoresAprobados'  => Repartidor::where('estado_aprobacion', 'aprobado')->count(),
            'repartidoresConectados' => Repartidor::where('estado_aprobacion', 'aprobado')
                ->whereIn('estado', ['disponible', 'ocupado'])->count(),
            'usuariosTotal'          => User::count(),
            'usuariosInactivos'      => User::where('activo', false)->count(),
            'comisionesTotal'        => (float) Comision::sum('monto_comision'),
        ]);
    }

    public function usuarios(Request $request)
    {
        $usuarios = User::query()
            ->when($request->filled('rol'), fn ($q) => $q->where('rol', $request->rol))
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('nombre', 'like', '%' . $request->q . '%')
                        ->orWhere('apellido', 'like', '%' . $request->q . '%')
                        ->orWhere('correo', 'like', '%' . $request->q . '%');
                });
            })
            ->orderBy('activo')
            ->orderByDesc('id_usuario')
            ->paginate(10)
            ->withQueryString();

        return view('admin.usuarios', ['usuarios' => $usuarios]);
    }

    public function alternarUsuario(Request $request, int $id)
    {
        $usuario = User::findOrFail($id);

        if ((int) $usuario->id_usuario === (int) $request->user()->id_usuario) {
            return response()->json(['message' => 'No puedes desactivar tu propia cuenta.'], 422);
        }

        $usuario->update(['activo' => !$usuario->activo]);

        return response()->json(['campos' => [
            'activo' => $usuario->activo ? 'Activo' : 'Inactivo',
            'accion' => $usuario->activo ? 'Desactivar' : 'Activar',
        ]]);
    }

    public function comercios(Request $request)
    {
        $comercios = Comercio::with(['usuario', 'tipo'])
            ->when($request->filled('estado'), fn ($q) => $q->where('estado_aprobacion', $request->estado))
            ->orderByRaw("estado_aprobacion = 'pendiente' desc")
            ->orderByDesc('id_comercio')
            ->paginate(10)
            ->withQueryString();

        return view('admin.comercios', ['comercios' => $comercios]);
    }

    public function estadoComercio(Request $request, int $id)
    {
        $request->validate([
            'estado' => ['required', Rule::in(['aprobado', 'rechazado', 'suspendido'])],
        ]);

        $comercio = Comercio::with('usuario')->findOrFail($id);
        $aprobado = $request->estado === 'aprobado';

        DB::transaction(function () use ($comercio, $request, $aprobado) {
            $comercio->update(['estado_aprobacion' => $request->estado]);
            $comercio->usuario->update(['activo' => $aprobado]);
        });

        return response()->json(['campos' => [
            'estado' => ucfirst($request->estado),
            'cuenta' => $aprobado ? 'Activa' : 'Inactiva',
        ]]);
    }

    public function repartidores(Request $request)
    {
        $repartidores = Repartidor::with(['usuario', 'zona'])
            ->when($request->filled('estado'), fn ($q) => $q->where('estado_aprobacion', $request->estado))
            ->orderByRaw("estado_aprobacion = 'pendiente' desc")
            ->orderByDesc('id_repartidor')
            ->paginate(10)
            ->withQueryString();

        return view('admin.repartidores', ['repartidores' => $repartidores]);
    }

    public function estadoRepartidor(Request $request, int $id)
    {
        $request->validate([
            'estado' => ['required', Rule::in(['aprobado', 'rechazado'])],
        ]);

        $repartidor = Repartidor::with('usuario')->findOrFail($id);
        $aprobado = $request->estado === 'aprobado';

        DB::transaction(function () use ($repartidor, $request, $aprobado) {
            $repartidor->update(['estado_aprobacion' => $request->estado]);
            $repartidor->usuario->update(['activo' => $aprobado]);
        });

        return response()->json(['campos' => [
            'estado' => ucfirst($request->estado),
            'cuenta' => $aprobado ? 'Activa' : 'Inactiva',
        ]]);
    }

    public function comisiones()
    {
        $comercios = Comercio::query()
            ->withCount('comisiones')
            ->withSum('comisiones', 'monto_comision')
            ->orderBy('nombre')
            ->get();

        return view('admin.comisiones', [
            'comercios'     => $comercios,
            'totalGenerado' => (float) Comision::sum('monto_comision'),
            'totalPedidos'  => Comision::count(),
            'promedio'      => (float) Comision::avg('porcentaje'),
        ]);
    }

    public function actualizarComision(Request $request, int $id)
    {
        $datos = $request->validate([
            'porcentaje' => ['required', 'numeric', 'between:0,100'],
        ]);

        $comercio = Comercio::findOrFail($id);
        $comercio->update(['porcentaje_comision' => $datos['porcentaje']]);

        return response()->json([
            'porcentaje' => number_format((float) $comercio->porcentaje_comision, 2, '.', ''),
        ]);
    }
}