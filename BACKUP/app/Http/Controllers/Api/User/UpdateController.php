<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreUser;
use Kaleidoscope\Factotum\Models\User;
use Kaleidoscope\Factotum\Models\Profile;


class UpdateController extends ApiBaseController
{

	public function update(StoreUser $request, $id)
	{
		$data = $request->all();

		$user = User::find($id);
		$user->fill( $data );
		$user->save();

		$profile = Profile::where( 'user_id', $user->id )->first();
		$profile->fill( $data );
		$profile->save();

        return response()->json( [ 'result' => 'ok', 'user'  => $user->toArray() ] );
	}

}
