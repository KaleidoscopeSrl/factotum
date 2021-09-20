<?php

namespace Kaleidoscope\Factotum\Http\Middleware;

use Closure;

class AddHeaderAccessToken
{
	public function handle($request, Closure $next)
	{
		if ($request->has('access_token')) {
			$request->headers->set('Authorization', 'Bearer ' . $request->get('access_token'));
		}
		return $next($request);
	}
}