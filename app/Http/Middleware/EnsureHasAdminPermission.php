<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureHasAdminPermission
{
    /**
     * Verifica que el usuario autenticado tenga el rol o permiso de administrador.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Si no está autenticado
        if (! $user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        // Si no tiene el rol "admin" ni el permiso "acceso-admin-dashboard"
        if (
            ! method_exists($user, 'hasRole') ||
            (
                ! $user->hasRole('admin') &&
                ! $user->hasPermissionTo('acceso-admin-dashboard')
            )
        ) {
            return redirect('/')
                ->with('error', 'Acceso denegado: no tienes permisos de administrador.');
        }

        return $next($request);
    }
}
