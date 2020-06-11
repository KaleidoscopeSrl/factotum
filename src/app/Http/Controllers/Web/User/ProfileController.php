<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\User;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;

use Kaleidoscope\Factotum\Http\Requests\UpdateUser;
use Kaleidoscope\Factotum\Http\Requests\UpdateDeliveryAddress;
use Kaleidoscope\Factotum\Http\Requests\UpdateInvoiceAddress;
use Kaleidoscope\Factotum\Profile;


class ProfileController extends Controller
{

	public function showProfileForm()
	{
		// TODO: aggiungere metatags
		return view('factotum::user.profile')->with( 'user', Auth::user() );
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

		session()->flash( 'message', 'Profilo aggiornato con successo!' );

		return view('factotum::user.profile')->with( 'user', Auth::user() );
	}

}
