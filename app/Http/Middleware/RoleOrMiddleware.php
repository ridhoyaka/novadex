<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleOrMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        foreach ($roles as $role) {
            if ($user->role->value === $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
