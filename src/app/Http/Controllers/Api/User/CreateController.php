<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Requests\StoreUser;
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
