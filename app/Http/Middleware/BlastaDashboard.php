<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\Response as AuthResponse;

class BlastaDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): object
    {
        $dashboardDefaultPages = [
            'home'
        ];

        $segments = $request->segments();

        if ($segments[0] === 'dashboard'
                && in_array($segments[1], $dashboardDefaultPages)
                && $_SERVER['SERVER_PORT'] == 8000) {
            abort(404);
            exit;
        }

        if ($segments[0] !== 'dashboard' && $_SERVER['SERVER_PORT'] == 8000) {
            abort(404);
        }

        return $next($request);
    }
}
