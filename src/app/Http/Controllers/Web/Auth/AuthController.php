<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;

class AuthController extends Controller
{
	protected $redirectTo = '/';

	use AuthenticatesUsers;

	public function showLoginForm(Request $request)
	{
		// TODO: aggiungere metatags
		return view('factotum::auth.login');
	}

}
