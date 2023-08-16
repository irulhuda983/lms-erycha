<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $roles = explode('|', $role);
        $user = $request->user();

        if(!in_array($user->role, $roles)) {
            abort(response()->json([
                'success' => false,
                'message' => 'Forbidden.',
            ], 403));
        }

        return $next($request);
    }
}
