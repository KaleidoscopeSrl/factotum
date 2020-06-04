<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;


class ResetPasswordController extends Controller
{
	use ResetsPasswords;

	protected $redirectTo = '/';

	public function showResetForm(Request $request, $token = null)
	{
		return view('factotum::auth.reset-password')->with(
			['token' => $token, 'email' => $request->email]
		);
	}

	// TODO: impaginare form reset password
}
