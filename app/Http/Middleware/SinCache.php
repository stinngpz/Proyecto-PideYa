<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SinCache
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    $respuesta = $next($request);

    $respuesta->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
    $respuesta->headers->set('Pragma', 'no-cache');
    $respuesta->headers->set('Expires', '0');

    return $respuesta;
}
}
