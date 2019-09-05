<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;

class LogoutController extends Controller
{
	/**
	 * Log the user out of the application.
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();
		$request->session()->flush();
		$request->session()->regenerate();
		return redirect('/admin/auth/login');
	}

	protected function guard()
	{
		return Auth::guard();
	}
}
