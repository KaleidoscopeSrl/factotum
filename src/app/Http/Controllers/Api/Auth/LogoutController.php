<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;

class LogoutController extends Controller
{

	public function logout(Request $request)
	{
		if ( $request->user() ) {
			$request->user()->token()->revoke();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
