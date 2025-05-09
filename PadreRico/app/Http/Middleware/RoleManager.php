<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verificar si el usuario está autenticado
        if (!$request->user()) {
            abort(403, 'Acceso denegado');
        }

        // Mapear los roles a sus valores
        $roles = [
            'admin' => 0,
            'user' => 1,
        ];

        // Verificar si el rol requerido existe en el mapa
        if (!array_key_exists($role, $roles)) {
            abort(403, 'Rol no válido');
        }

        // Verificar si el usuario tiene el rol requerido
        if ($request->user()->role !== $roles[$role]) {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
}
