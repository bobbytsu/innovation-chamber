<?php

namespace App\Http\Middleware;

use Closure;

class CheckPostOwner
{
    /**
     * Memeriksa apakah pengguna adalah pemilik dari sebuah Post
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->id == $request->post->user_id) {
            
            return $next($request);
        }

        return redirect()->back();
    }
}
