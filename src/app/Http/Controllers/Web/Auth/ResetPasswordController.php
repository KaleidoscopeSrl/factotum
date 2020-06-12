<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;


class ResetPasswordController extends Controller
{
	use ResetsPasswords;

	protected $redirectTo = '/';

	public function showResetForm(Request $request, $token = null)
	{
		return view('factotum::auth.reset-password')
					->with([
						'token' => $token,
						'email' => $request->email,
						'metatags' => [
							'title'       => Lang::get('factotum::auth.reset_password_title'),
							'description' => Lang::get('factotum::auth.reset_password_description')
						]
					]);
	}
}
