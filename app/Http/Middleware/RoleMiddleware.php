<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    // app/Http/Middleware/RoleMiddleware.php
public function handle($request, \Closure $next, ...$roles)
{
    // ✅ Permite rutas de cuenta y logout SIN chequear rol
    if (
        $request->is('account/*') ||
        $request->routeIs('account.*') ||
        $request->routeIs('logout')
    ) {
        return $next($request);
    }

    $user = $request->user();
    if (!$user) {
        return redirect()->route('login'); // asegúrate que sea 'login'
    }

    $nombreRol = strtolower($user->rol->nombre ?? '');
    if (!in_array($nombreRol, array_map('strtolower', $roles), true)) {
        abort(403, 'No tienes permisos para acceder aquí.');
    }

    return $next($request);
}

}
