<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;

class LoginController extends Controller
{
	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request)
	{
		$this->messages['exist'] = 'Non esiste nessun utente con questa :attribute.';

		if ( $request->input('email') ) {
			$request->request->add([ 'email' => $request->input('email') ]);
		}

		$validator = Validator::make( $request->all() , [
			'email'       => 'required|exists:users',
			'password'    => 'required|min:8'
		], $this->messages);

		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			return $this->_sendJsonError( $errors[0] );
		}

		$email = $request->input('email');


		$credentials = [
			'email'     => $email,
			'password'  => request('password')
		];



		if ( !Auth::attempt($credentials) ) {
			return $this->_sendJsonError( 'La password non è corretta per questo account o l\'utente ha effettuato troppi tentativi.', 401 );
		}

		$user = Auth::user();
		$user->load('profile');

		$token = $user->createToken('Factotum')->accessToken;

		return response()->json([
			'result'     => 'ok',
			'user'       => $user->toArray(),
			'token'      => $token
		]);
	}



	/**
	 * Get the Closure which is used to build the password reset notification.
	 *
	 * @return \Closure
	 */
	protected function resetNotifier() { }

	/**
	 * Get the broker to be used during password reset.
	 *
	 * @return \Illuminate\Contracts\Auth\PasswordBroker
	 */
	public function _broker()
	{
		return Password::broker();
	}

}
