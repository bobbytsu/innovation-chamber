<?php

namespace App\Http\Middleware;

use Closure;

class CheckPostReviewOwner
{
    /**
     * Memeriksa apakah pengguna adalah pemilik Review dari sebuah Post
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->id == $request->post->stage1->review->reviewerid || $request->user()->id == $request->post->stage2->review->reviewerid || $request->user()->id == $request->post->stage3->review->reviewerid || $request->user()->id == $request->post->stage4->review->reviewerid || $request->user()->id == $request->post->stage5->review->reviewerid) {
            
            return $next($request);
        }

        return redirect()->back();
    }
}
