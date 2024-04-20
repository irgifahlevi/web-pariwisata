<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika request user adalah admin maka requestnya di teruskan
        if ($request->user()->role == 'admin') {
            return $next($request);
        }

        // Jika request user yang masuk bukan admin maka redirect
        abort(403, 'Aksess khusus admin!');
    }
}
