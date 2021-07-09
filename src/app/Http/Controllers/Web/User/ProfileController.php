<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;

use Kaleidoscope\Factotum\Http\Requests\UpdateUser;
use Kaleidoscope\Factotum\Models\Profile;


class ProfileController extends Controller
{

	public function showProfileForm()
	{
		return view('factotum::user.profile')->with([
			'user'     => Auth::user(),
			'metatags' => [
				'title'       => Lang::get('factotum::user.profile_title'),
				'description' => Lang::get('factotum::user.profile_description')
			]
		]);
	}



	public function update(UpdateUser $request)
	{
		$data = $request->all();

		$user = Auth::user();
		$user->email = $data['email'];
		if ( $data['password'] != '' ) {
			$user->password = $data['password'];
		}
		$user->save();


		$profile = Profile::where( 'user_id', $user->id )->first();
		$profile->fill( $data );
		$profile->save();

		session()->flash( 'message', Lang::get('factotum::user.user_updated') );

		return redirect('/user/profile');
	}

}
