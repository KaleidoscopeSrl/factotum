<?php

namespace Kaleidoscope\Factotum\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$language = $request->session()->get('currentLanguage');

		if ( !$language ) {
			$language = config('factotum.main_site_language');
			$request->session()->put('currentLanguage', $language);
		}

		app()->setLocale( $language );
		return $next($request);
    }
}
