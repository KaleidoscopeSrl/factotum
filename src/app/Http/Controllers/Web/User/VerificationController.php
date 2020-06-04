<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\User;

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;

class VerificationController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Email Verification Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling email verification for any
	| user that recently registered with the application. Emails may also
	| be re-sent if the user didn't receive the original email message.
	|
	*/

	use VerifiesEmails;


	protected $redirectTo = '/';


	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('signed')->only('verify');
		$this->middleware('throttle:6,1')->only('verify', 'resend');
	}

	public function show(Request $request)
	{
		// TODO: aggiungere metatags
		return $request->user()->hasVerifiedEmail()
			? redirect($this->redirectPath())
			: view('factotum::user.verify');
	}

}