<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the authenticated user has the 'admin' role
            if (Auth::user()->role === 'admin') {
                // User is an admin, allow access to the requested route
                return $next($request);
            }
        }

        // User is not an admin, you can customize this part based on your requirements
        abort(403, 'Unauthorized action.'); // For example, you can return a 403 Forbidden response

        // Alternatively, you can redirect the user to a login page or another route
        // return redirect('/login');

        // You can customize this part based on how you want to handle non-admin users
    }
}
