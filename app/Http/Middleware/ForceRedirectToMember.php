<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceRedirectToMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $force = \Session::has( 'forceRedirectToMember' );

        if ( $force ) {
            \Session::forget( 'forceRedirectToMember' );

            return redirect( url( '/' ) );
        }

        return $next($request);
    }
}
