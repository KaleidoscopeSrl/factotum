<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Requests\StoreUser;
use Kaleidoscope\Factotum\User;


class UpdateController extends Controller
{

	public function update(StoreUser $request, $id)
	{
		$data = $request->all();

		$user = User::find($id);
		$user->fill( $data );
		$user->setAvatar( $request );
		$user->save();

		$this->_saveProfile( $request, $user );

		// $user = $this->_save( $request, $user, $profile );

        return response()->json( [ 'result' => 'ok', 'user'  => $user->toArray() ] );
	}

}
