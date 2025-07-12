<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAgent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Use the 'agent' guard (make sure it's configured in config/auth.php)
        if (!\Illuminate\Support\Facades\Auth::guard('agent')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Agent authentication required.'
            ], 401);
        }

        return $next($request);
    }
}
