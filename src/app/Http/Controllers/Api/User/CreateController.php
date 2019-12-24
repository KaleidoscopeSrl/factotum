<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Kaleidoscope\Factotum\Http\Requests\StoreUser;
use Kaleidoscope\Factotum\Profile;
use Kaleidoscope\Factotum\User;

class CreateController extends Controller
{

	public function create(StoreUser $request)
	{
		$data = $request->all();

		$user = new User;
		$user->fill( $data );
		$user->setAvatar( $request );
		$user->save();

		$data['user_id'] = $user->id;
		$profile = new Profile;
		$profile->fill( $data );
		$profile->save();

		return response()->json( [ 'result' => 'ok', 'user'  => $user->toArray() ] );
	}

}
