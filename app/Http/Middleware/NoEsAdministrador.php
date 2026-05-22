<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoEsAdministrador
{
    /**
     * Permite el acceso solo a usuarios normales (no admins).
     * Si el usuario es admin, se le redirige a su panel.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->rol_id === 2) {
            return redirect()->route('admin.panel');
        }

        return $next($request);
    }
}
