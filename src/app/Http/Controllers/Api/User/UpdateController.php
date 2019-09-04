<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Role;

class UpdateController extends Controller
{

	public function update(Request $request, $id)
	{
		$this->validator($request->all(), $id)->validate();

		$user = User::find($id);
		$profile = $user->profile;

		$this->_save( $request, $user, $profile );

        return response()->json( [ 'result' => 'ok', 'role'  => $user->toArray() ] );
	}
}
