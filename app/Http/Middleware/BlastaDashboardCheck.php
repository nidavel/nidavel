<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class BlastaDashboardCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);

        if (empty($_GET['route'])) {
            return redirect('/dashboard?route=dashboard/home');
        }

        if (!Hash::check($request->query('route'), base64_decode($request->token))) {
            return redirect('/');
        }

        return $response;
    }
}
