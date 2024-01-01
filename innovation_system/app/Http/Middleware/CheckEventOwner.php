<?php

namespace App\Http\Middleware;

use Closure;

class CheckEventOwner
{
    /**
     * Memeriksa apakah pengguna adalah pemilik dari sebuah Event
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->id == $request->event->user_id) {
            
            return $next($request);
        }

        return redirect()->back();
    }
}
