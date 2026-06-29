<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarCajaAbierta
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si existe al menos una caja con estado abierto (true)
        $cajaAbierta = \App\Models\Caja::where('estado', true)->exists();

        if (!$cajaAbierta) {
            // Redirige al dashboard o a la gestión de cajas con un mensaje
            return redirect()->route('cajas.index')->with('alerta_error', 'Debes aperturar una caja antes de realizar ventas.');
        }

        return $next($request);
    }
}
