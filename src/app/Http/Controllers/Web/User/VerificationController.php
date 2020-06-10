<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Verified;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;
use Kaleidoscope\Factotum\User;

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


	protected $redirectTo = '/?verified=1';


	public function __construct()
	{
		// $this->middleware('auth');
		$this->middleware('signed')->only('verify');
		$this->middleware('throttle:6,1')->only('verify', 'resend');
	}

	public function show(Request $request)
	{
		// TODO: aggiungere metatags
		return $request->user()->hasVerifiedEmail() ? redirect($this->redirectPath()) : view('factotum::user.verify');
	}


	public function verify(Request $request)
	{
		if (! (string) $request->route('id') ) {
			throw new AuthorizationException;
		}

		$user = User::find( $request->route('id') );

		if (! hash_equals((string) $request->route('hash'), sha1($user->email) )) {
			throw new AuthorizationException;
		}

		if ( $user->hasVerifiedEmail() ) {
			return $request->wantsJson() ? new Response('', 204) : redirect($this->redirectPath());
		}

		if ( $user->markEmailAsVerified() ) {
			event(new Verified($request->user()));
		}

		session()->flash( 'message', 'Utente verificato con successo!' );

		if ( $response = $this->verified($request) ) {
			return $response;
		}

		return $request->wantsJson() ? new Response('', 204) : redirect($this->redirectPath())->with('verified', true);
	}

}