<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsAdministrador
{
    /**
     * Permite el acceso solo a usuarios con rol de administrador.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está autenticado, redirigir al login.
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Comprobar que el usuario tiene rol de administrador (rol_id = 2).
        if (auth()->user()->rol_id !== 2) {
            abort(403, 'Acceso restringido. Solo administradores.');
        }

        // Si todo OK, dejar pasar.
        return $next($request);
    }
}
