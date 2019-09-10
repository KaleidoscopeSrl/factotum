<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;
use Kaleidoscope\Factotum\Mail\AuthForgottenPassword;
use Kaleidoscope\Factotum\User;


class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;


    public function __construct()
    {
        $this->middleware('guest');
    }


	public function forgottenPassword(Request $request)
	{
		$validator = Validator::make( $request->all() , [
			'email' => 'required|max:255|exists:users',
		], $this->messages);

		if ( $validator->fails() ) {
			$errors = $validator->errors()->all();
			return $this->_sendJsonError( $errors[0] );
		}

		$user = User::with('profile')->where('email', $request->input('email') )->first();

		if ( $user ) {
			$newPassword    = Str::random(8);
			$user->password = Hash::make( $newPassword );
			$user->save();

			Mail::to( $user->email )
				->send( new AuthForgottenPassword( $user, $newPassword ) );

			// check for failures
			if ( Mail::failures() ) {
				$response = Mail::failures();
			} else {
				return response()->json( [ 'result' => 'ok' ]);
			}
		}

		return $this->_sendJsonError( 'Impossibile recuperare la password' );

	}
}
