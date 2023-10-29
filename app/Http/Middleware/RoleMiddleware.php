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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();
        $allowedRoles = explode('|', $role);
        if ($user && in_array($user->role, $allowedRoles)) {
            return $next($request);
        }
        return response()->json(['error' => 'unauthorized user!'], 403);
    }
}
