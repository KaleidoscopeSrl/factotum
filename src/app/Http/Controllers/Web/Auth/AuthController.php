<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;
use Kaleidoscope\Factotum\Traits\CartUtils;

class AuthController extends Controller
{
	protected $redirectTo = '/';

	use AuthenticatesUsers;
	use CartUtils;

	public function showLoginForm(Request $request)
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
