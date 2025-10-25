<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureHasAdminPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user || ! method_exists($user, 'hasPermissionTo') || ! $user->hasPermissionTo('acceso-admin-dashboard')) {
            // Redirigir al home con mensaje
            return redirect('/')->with('error', 'Acceso denegado');
        }

        return $next($request);
    }
}
