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
		$view = 'factotum::auth.reset-password';
		if ( file_exists( resource_path('views/auth/reset-password.blade.php') ) ) {
			$view = 'auth.reset-password';
		}

		return view( $view )
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
