<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Validation\ValidationException;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;
use Kaleidoscope\Factotum\Traits\CartUtils;


class AuthController extends Controller
{
	protected $redirectTo = '/auth/login';

	use AuthenticatesUsers;

	use CartUtils;
	
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
			: redirect()->intended( '/' );
	}


	protected function authenticated(Request $request, $user)
	{
		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {

			if ( $request->session()->get('force_extend_cart') ) {
				$user = Auth::user();
				$cart = Cart::where( 'customer_id', $user->id )->orderBy('id', 'DESC')->first();
				$cart->expires_at  = date('Y-m-d H:i:s',  time() + 120 );
				$cart->save();

				$request->session()->remove('force_extend_cart');
			}

			$this->_extendCart();
		}
	}

}
