<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Memeriksa Role dari pengguna
     */
    public function handle($request, Closure $next, $role)
    {
        if($request->user()->role == $role) {
            
            return $next($request);
        }

        return redirect()->back();
    }
}
