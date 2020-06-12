<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;
use Kaleidoscope\Factotum\Traits\CartUtils;

class AuthController extends Controller
{
	protected $redirectTo = '/';

	use AuthenticatesUsers;
	use CartUtils;

	public function showLoginForm(Request $request)
	{
		return view('factotum::auth.login')
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
			$this->_extendCart();
		}
	}

}
