<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

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

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
	 * @param  string  $password
	 * @return void
	 */
	protected function resetPassword($user, $password)
	{
		$this->setUserPassword($user, $password);

		$user->setRememberToken(Str::random(60));
		$user->email_verified_at = date('Y-m-d H:i:s');
		$user->save();

		event(new PasswordReset($user));

		if ( !$user->isProfileComplete() ) {
			$this->redirectTo = '/user/profile';
		}

		$this->guard()->login($user);
	}

}
