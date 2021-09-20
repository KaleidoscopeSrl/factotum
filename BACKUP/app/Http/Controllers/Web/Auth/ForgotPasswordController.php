<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;


class ForgotPasswordController extends Controller
{
	use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');

        parent::__construct();
    }

    public function showLinkRequestForm( Request $request )
	{
		$view = 'factotum::auth.forgot-password';
		if ( file_exists( resource_path('views/auth/forgot-password.blade.php') ) ) {
			$view = 'auth.forgot-password';
		}

		return view( $view )
					->with([
						'metatags' => [
							'title'       => Lang::get('factotum::auth.forgot_password_title'),
							'description' => Lang::get('factotum::auth.forgot_password_description')
						]
					]);
	}

}
