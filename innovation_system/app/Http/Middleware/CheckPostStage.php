<?php

namespace App\Http\Middleware;

use Closure;

class CheckPostStage
{
    /**
     * Memeriksa Stage dari sebuah Post
     */
    public function handle($request, Closure $next, $stage)
    {
        if($request->post->stage >= $stage){
                
            return $next($request);
        }

        return redirect()->back();
    }
}
