<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSystem
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role_id === 1) {

            return $next($request);
        } else {
            return response()->json([
                'status code' => 403, 
                'message' => "Sorry, vous n'êtes pas autorisé à accéder à cette ressource réservé à l'Administrateur de ce système."
            ], 403);
        }
    }
}
