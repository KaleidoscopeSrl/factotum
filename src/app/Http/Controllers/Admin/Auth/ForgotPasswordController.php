<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Auth;

use Kaleidoscope\Factotum\Http\Controllers\Admin\Controller;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
	private $redirectTo = '/admin/auth/login';

	public function index()
	{
		return view('factotum::admin.auth.passwords.email');
	}

	public function broker()
	{
		return Password::broker();
	}

	public function sendResetLinkEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		$response = $this->broker()->sendResetLink(
			$request->only('email')
		);

		if ($response === Password::RESET_LINK_SENT) {
			return back()->with('status', trans($response));
		}
	}

	public function reset(Request $request, $token = null)
	{
		return view('factotum::admin.auth.passwords.reset')->with(
			['token' => $token, 'email' => $request->email]
		);
	}

	public function resetUserPassword(Request $request)
	{
		$this->validate($request, [
			'token'    => 'required',
			'email'    => 'required|email',
			'password' => 'required|confirmed|min:6',
		]);

		$response = $this->broker()->reset(
			$this->credentials($request), function ($user, $password) {
			$this->resetPassword($user, $password);
		});

		return $response == Password::PASSWORD_RESET
			? $this->sendResetResponse($response)
			: $this->sendResetFailedResponse($request, $response);
	}

	protected function credentials(Request $request)
	{
		return $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);
	}

	protected function resetPassword($user, $password)
	{
		$user->forceFill([
			'password' => bcrypt($password),
			'remember_token' => Str::random(60),
		])->save();

		$this->guard()->login($user);
	}

	protected function sendResetResponse($response)
	{
		return redirect( $this->redirectPath() )->with('status', trans($response));
	}

	protected function sendResetFailedResponse(Request $request, $response)
	{
		return redirect()->back()
			->withInput($request->only('email'))
			->withErrors(['email' => trans($response)]);
	}

	public function redirectPath()
	{
		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/admin/auth/login';
	}
}



