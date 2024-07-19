<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Vérifie si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Vérifie si l'utilisateur a le rôle requis
        if ($request->user()->role !== $role) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
