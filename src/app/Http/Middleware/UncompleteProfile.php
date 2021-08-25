<?php

namespace Kaleidoscope\Factotum\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;


class UncompleteProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	public function handle($request, Closure $next, $guard = null)
    {
	    if ( Auth::guard($guard)->check() ) {
	    	$user = Auth::user();
		    if ( !$user->isProfileComplete() ) {
			    return redirect('/user/profile?complete_profile=1');
		    }
	    }

		return $next($request);
    }

}
