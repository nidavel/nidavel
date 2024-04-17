<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($_SERVER['REQUEST_URI'] !== '/installation' && file_exists(base_path('/install'))) {
            return redirect()->to('/installation');
        }
        
        return $next($request);
    }
}
