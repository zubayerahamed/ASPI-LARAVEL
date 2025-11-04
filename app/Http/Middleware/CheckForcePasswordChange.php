<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->requiresPasswordChange()) {
            // For API requests
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Password change required.',
                ], 423);
            }

            // For web requests - redirect to password change page
            if (!$request->is('set-password*') && !$request->is('logout')) {
                return redirect()->route('password.set');
            }
        }

        return $next($request);
    }
}
