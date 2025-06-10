<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();
        if (!$user) {
            abort(403);
        }

        if ($role === 'management') {
            if (!str_starts_with($user->role, 'management-')) {
                abort(403);
            }
        } else {
            if ($user->role !== $role) {
                abort(403);
            }
        }

        return $next($request);
    }
}
