<?php

namespace App\Http\Middleware;

use Closure;

class VerifyPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $redirect_URL = null)
    {
        if ( !$request->isMethod("post") )
        {
            return redirect()->to( $redirect_URL );
        }

        return $next($request);
    }
}
