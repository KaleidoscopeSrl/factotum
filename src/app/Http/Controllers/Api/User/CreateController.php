<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\Profile;

class CreateController extends Controller
{

	public function create(Request $request)
	{
		$this->_validate( $request );

		$user = new User;
		$user->editable = true;

		$profile = new Profile;
		$user = $this->_save( $request, $user, $profile );

		return response()->json( [ 'result' => 'ok', 'user'  => $user->toArray() ] );
	}

}
