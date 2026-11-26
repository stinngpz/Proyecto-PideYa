<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepartidorAprobado
{
    public function handle(Request $request, Closure $next): Response
    {
        $repartidor = $request->user()->repartidor;

        if (!$repartidor || $repartidor->estado_aprobacion != 'aprobado') {
            return redirect()->route('solicitud');
        }

        return $next($request);
    }
}
