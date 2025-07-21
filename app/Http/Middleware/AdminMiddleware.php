<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            // If the user is not authenticated or not an admin, redirect to the dashboard or an error page
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        return $next($request);
    }
}
