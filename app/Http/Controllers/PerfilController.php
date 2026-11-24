<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function editar()
    {
        return view('cliente.perfil', ['usuario' => Auth::user()]);
    }

    public function actualizar(PerfilRequest $request)
    {
        $request->user()->update($request->validated());

        return back()->with('exito', 'Tus datos se actualizaron correctamente.');
    }

    public function cuenta()
    {
        return view('cliente.cuenta');
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'password_actual' => ['required', 'current_password'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update(['password' => $request->password]);

        return back()->with('exito', 'Tu contraseña se actualizó correctamente.');
    }
}