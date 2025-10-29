<?php

namespace App\Http\Middleware;

use Closure;

class PermisoMiddleware
{
    public function handle($request, Closure $next, $permiso)
    {
        $user = auth()->user();

        // Asumo relación: $user->rol->permisos()->pluck('nombre')
        $tiene = $user && $user->rol
            ? $user->rol->permisos()->where('nombre', $permiso)->exists()
            : false;

        abort_unless($tiene, 403, 'No tienes el permiso requerido.');

        return $next($request);
    }
}
