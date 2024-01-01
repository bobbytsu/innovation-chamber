<?php

namespace App\Http\Middleware;

use Closure;

class CheckCommentOwner
{
    /**
     * Memeriksa apakah pengguna adalah pemilik dari sebuah Komentar
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->id == $request->comment->user_id) {
            
            return $next($request);
        }

        return redirect()->back();
    }
}
