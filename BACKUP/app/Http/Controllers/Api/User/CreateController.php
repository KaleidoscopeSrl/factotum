<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreUser;
use Kaleidoscope\Factotum\Models\Profile;
use Kaleidoscope\Factotum\Models\User;


class CreateController extends ApiBaseController
{

	public function create(StoreUser $request)
	{
		$data = $request->all();

		$user = new User;
		$user->fill( $data );
		$user->save();

		$data['user_id'] = $user->id;
		$profile = new Profile;
		$profile->fill( $data );
		$profile->save();

		return response()->json( [ 'result' => 'ok', 'user'  => $user->toArray() ] );
	}

}
