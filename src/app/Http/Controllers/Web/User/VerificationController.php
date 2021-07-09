<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\User;

use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Verified;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;
use Kaleidoscope\Factotum\Models\User;


class VerificationController extends Controller
{

	use VerifiesEmails;


	protected $redirectTo = '/user/verified';


	public function __construct()
	{
		parent::__construct();

		// NOT MANDATORY TO BE SIGNED IN
		// $this->middleware('auth');
		$this->middleware('signed')->only('verify');
		$this->middleware('throttle:6,1')->only('verify', 'resend');
	}


	public function show(Request $request)
	{
		return $request->user()->hasVerifiedEmail() ?
					redirect($this->redirectPath()) :
					view('factotum::user.verify')
						->with([
							'metatags' => [
								'title'       => Lang::get('factotum::user.email_verification_title'),
								'description' => Lang::get('factotum::user.email_verification_description')
							]
						]);
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

		session()->flash( 'message', Lang::get('factotum::user.user_verified') );

		if ( $response = $this->verified($request) ) {
			return $response;
		}

		return $request->wantsJson() ? new Response('', 204) : redirect( $this->redirectPath() . '/' . $user->id )->with('verified', true);
	}


	public function showVerified(Request $request, $id )
	{
		$user = User::find($id);

		return view('user.verified')
				->with([
					'user' => $user,
					'metatags' => [
						'title'       => Lang::get('factotum::user.email_verification_thankyou_title'),
						'description' => Lang::get('factotum::user.email_verification_thankyou_description')
					]
				]);
	}

}