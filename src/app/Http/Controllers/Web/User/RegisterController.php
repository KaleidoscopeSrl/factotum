<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\User;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;
use Kaleidoscope\Factotum\Http\Requests\RegisterUser;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Profile;


class RegisterController extends Controller
{

	use RegistersUsers;

	protected $redirectTo = '/';


	public function __construct()
	{
		$this->middleware('guest');

		parent::__construct();
	}


	public function showRegistrationForm()
	{
		// TODO: aggiungere metatags
		return view('factotum::user.register');
	}


	public function register(RegisterUser $request)
	{
		$data = $request->all();
		$user = new User;
		$user->fill( $data );
		$user->save();

		$profile = new Profile;
		$data['user_id'] = $user->id;
		$profile->fill( $data );
		$profile->save();

		event( new Registered( $user ) );

		// $this->guard()->login($user);

		if ( $response = $this->registered($request, $user) ) {
			return $response;
		}

		return $request->wantsJson() ? new Response( '', 201 ) : redirect($this->redirectPath());
	}

}