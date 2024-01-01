<?php

namespace App\Http\Middleware;

use Closure;

class CheckUploadOwner
{
    /**
     * Memeriksa apakah pengguna adalah pemilik dari sebuah Upload
     * Metode ini hanya dapat diakses oleh pengguna dengan role 'Master' dan 'Administrator'
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->id == $request->upload->user_id) {
            
            return $next($request);
        }

        return redirect()->back();
    }
}
