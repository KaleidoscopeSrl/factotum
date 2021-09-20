<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Validation\ValidationException;

use Kaleidoscope\Factotum\Models\Cart;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;
use Kaleidoscope\Factotum\Traits\EcommerceUtils;


class AuthController extends Controller
{
	protected $redirectTo                 = '/auth/login';
	protected $redirectToEmailNotVerified = '/auth/email-not-verified';
	protected $successRedirectTo          = '/?login=ok';

	use AuthenticatesUsers;

	use EcommerceUtils;


	public function redirectTo()
	{
		return '/auth/login';
	}


	public function showLoginForm( Request $request )
	{
		if ( $request->input('abandonedCart') ) {
			$request->session()->put('force_extend_cart', 1);
		}

		$view = 'factotum::auth.login';
		if ( file_exists( resource_path('views/auth/login.blade.php') ) ) {
			$view = 'auth.login';
		}

		return view($view)
					->with([
						'metatags' => [
							'title'       => Lang::get('factotum::auth.login_title'),
							'description' => Lang::get('factotum::auth.login_description')
						]
					]);
	}


	public function showEmailNotVerified( Request $request )
	{

		$view = 'factotum::auth.email-not-verified';
		if ( file_exists( resource_path('views/auth/email-not-verified.blade.php') ) ) {
			$view = 'auth.email-not-verified';
		}

		return view($view)
				->with([
					'metatags' => [
						'title'       => Lang::get('factotum::auth.email_not_verified_title'),
						'description' => Lang::get('factotum::auth.email_not_verified_description')
					]
				]);
	}


	protected function sendFailedLoginResponse(Request $request)
	{
		$exception = ValidationException::withMessages([
			$this->username() => [trans('auth.failed')],
		]);

		$exception->redirectTo = '/auth/login';

		throw $exception;
	}
	

	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();
		
		$this->clearLoginAttempts($request);
		
		if ($response = $this->authenticated($request, $this->guard()->user())) {
			return $response;
		}
		
		return $request->wantsJson()
			? new JsonResponse([], 204)
			: redirect()->intended( $this->successRedirectTo );
	}


	protected function authenticated(Request $request, $user)
	{
		$user = Auth::user();

		if ( !$user->email_verified_at ) {
			Auth::logout();
			return $request->wantsJson() ? new JsonResponse([], 401) : redirect( $this->redirectToEmailNotVerified );
		}

		if ( !$user->isProfileComplete() ) {
			$this->successRedirectTo = '/user/profile?complete_profile=1';
		}

		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {

			if ( $request->session()->get('force_extend_cart') ) {
				$cart = Cart::where( 'customer_id', $user->id )->orderBy('id', 'DESC')->first();
				$cart->expires_at  = date('Y-m-d H:i:s',  time() + 120 );
				$cart->save();

				$request->session()->remove('force_extend_cart');
			}

			$this->_extendCart();
		}
	}

}
