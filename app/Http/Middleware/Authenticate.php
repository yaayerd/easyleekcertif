<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate 
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }
    
    public function handle($request, Closure $next)
    {
        
        if (Auth::check()) {
            return $next($request);
        }
        return response()->json([
            "status" => false,
            "status_code" => 403,
            "message" => "Vous n'êtes pas connecté vous ne pouvez accéder à cette page."
        ]);
    }
}
