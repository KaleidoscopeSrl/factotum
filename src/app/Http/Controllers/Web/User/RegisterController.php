<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\User;

use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;
use Kaleidoscope\Factotum\Http\Requests\RegisterUser;
use Kaleidoscope\Factotum\Models\User;
use Kaleidoscope\Factotum\Models\Profile;


class RegisterController extends Controller
{

	use RegistersUsers;

	protected $redirectTo = '/user/thank-you';


	public function __construct()
	{
		$this->middleware('guest');

		parent::__construct();
	}


	public function showRegistrationForm()
	{
		$view = 'factotum::user.register';
		if ( file_exists( resource_path('views/user/register.blade.php') ) ) {
			$view = 'user.register';
		}

		return view( $view )
				->with([
					'metatags' => [
						'title'       => Lang::get('factotum::user.registration_title'),
						'description' => Lang::get('factotum::user.registration_description')
					]
				]);
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

		// NO AUTO LOGIN AFTER REGISTRATION
		// $this->guard()->login($user);

		if ( $response = $this->registered($request, $user) ) {
			return $response;
		}

		return $request->wantsJson() ? new Response( '', 201 ) : redirect($this->redirectTo);
	}


	public function showThankyou( Request $request )
	{
		$view = 'factotum::user.thank-you';
		if ( file_exists( resource_path('views/user/thank-you.blade.php') ) ) {
			$view = 'user.thank-you';
		}

		return view( $view )
				->with([
					'metatags' => [
						'title'       => Lang::get('factotum::user.thankyou_title'),
						'description' => Lang::get('factotum::user.thankyou_description')
					]
				]);
	}

}