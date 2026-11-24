<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\Comercio;
use App\Models\Repartidor;
use App\Models\TipoComercio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formulario()
    {
        return view('auth.acceso', ['tipos' => TipoComercio::orderBy('nombre')->get()]);
    }

    public function registrar(RegistroRequest $request)
    {
        $datos = $request->validated();

        $usuario = DB::transaction(function () use ($datos) {
            $usuario = User::create([
                'nombre'   => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'correo'   => $datos['correo'],
                'telefono' => $datos['telefono'],
                'password' => $datos['password'],
                'rol'      => $datos['rol'],
                'activo'   => $datos['rol'] === 'cliente',
            ]);

            if ($datos['rol'] === 'comercio') {
                Comercio::create([
                    'id_usuario'       => $usuario->id_usuario,
                    'id_tipo_comercio' => $datos['id_tipo_comercio'],
                    'nombre'           => $datos['nombre_negocio'],
                    'rtn'              => $datos['rtn'],
                    'descripcion'      => $datos['descripcion'],
                ]);
            }

            if ($datos['rol'] === 'repartidor') {
                Repartidor::create(['id_usuario' => $usuario->id_usuario]);
            }

            return $usuario;
        });

        if (!$usuario->activo) {
            return redirect()->route('login')
                ->with('info', 'Cuenta creada. Un administrador debe aprobarla antes de que puedas ingresar.');
        }

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('panel');
    }

    public function ingresar(LoginRequest $request)
    {
        $usuario = User::where('correo', $request->correo)->first();
        if ($usuario && !$usuario->activo && Hash::check($request->password, $usuario->password)) {
            return back()->withErrors(['correo' => 'Tu cuenta está pendiente de aprobación.'])
                         ->onlyInput('correo');
        }

        $credenciales = [
            'correo'   => $request->correo,
            'password' => $request->password,
            'activo'   => true,
        ];

        if (!Auth::attempt($credenciales, $request->boolean('recordar'))) {
            return back()->withErrors(['correo' => 'Correo o contraseña incorrectos.'])
                         ->onlyInput('correo');
        }

        $request->session()->regenerate();

        return redirect()->route('panel');
    }

    public function panel()
    {
        return match (Auth::user()->rol) {
            'admin'      => redirect('/admin'),
            'comercio'   => redirect('/comercio'),
            'repartidor' => redirect('/repartidor'),
            default      => redirect('/cliente'),
        };
    }

    public function salir(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}