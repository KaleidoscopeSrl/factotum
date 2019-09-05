<?php

namespace Kaleidoscope\Factotum\Http\Middleware;

use Closure;

class PreflightResponse
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
		if ( isset($_SERVER['HTTP_ORIGIN']) ) {
			// ALLOW OPTIONS METHOD
			$headers = [
				'Access-Control-Allow-Origin'      => $_SERVER['HTTP_ORIGIN'],
				'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
				'Access-Control-Allow-Headers'     => 'Accept, Content-Type, Origin, Authorization',
				'Access-Control-Allow-Credentials' => 'true'
			];
		}

		if ( $request->getMethod() === 'OPTIONS' && isset($headers) ) {
			return response('OK', 200, $headers);
		} else {
			if ( isset($_SERVER['HTTP_ORIGIN']) ) {
				header('Access-Control-Allow-Origin: ' . '*'); //. $_SERVER['HTTP_ORIGIN']);
				header('Access-Control-Allow-Headers: Content-Type, Origin, Authorization');
				header('Access-Control-Allow-Credentials: true');
			}

		}

		return $next($request);
    }

}
