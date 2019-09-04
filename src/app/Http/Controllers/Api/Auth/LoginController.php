<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;

class LoginController extends Controller
{
	use RedirectsUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	//protected $redirectTo = '/admin/pages/';
	protected $redirectTo = '/admin';

	public function index()
	{
		return view('factotum::admin.auth.login');
	}


	public function login(Request $request)
	{
		$this->validateLogin($request);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		$credentials = $this->credentials($request);

		if ($this->guard()->attempt($credentials, $request->has('remember'))) {

			$user = $this->guard()->user();

			if ( $user->role->backend_access ) {
				return $this->sendLoginResponse($request);
			} else {
				$this->guard()->logout();
				$request->session()->flush();
				$request->session()->regenerate();

				return $this->sendNotAuthLoginResponse($request);
			}

		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}


	/**
	 * Validate the user login request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 */
	protected function validateLogin(Request $request)
	{
		$this->validate($request, [
			$this->username() => 'required', 'password' => 'required',
		]);
	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	protected function credentials(Request $request)
	{
		return $request->only($this->username(), 'password');
	}

	/**
	 * Send the response after the user was authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();
		$this->clearLoginAttempts($request);
		return $this->authenticated($request, $this->guard()->user()) ? : redirect()->intended($this->redirectPath());
	}

	/**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		$request->session()->put('currentLanguage', config('factotum.factotum.main_site_language') );
	}

	/**
	 * Get the failed login response instance.
	 *
	 * @param \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	protected function sendFailedLoginResponse(Request $request)
	{
		return redirect()->back()
			->withInput($request->only($this->username(), 'remember'))
			->withErrors([
				$this->username() => Lang::get('factotum::auth.failed'),
			]);
	}

	protected function sendNotAuthLoginResponse(Request $request)
	{
		return redirect()->back()
			->withInput($request->only($this->username(), 'remember'))
			->withErrors([
				$this->username() => Lang::get('factotum::auth.not_auth'),
			]);
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		return 'email';
	}

}
