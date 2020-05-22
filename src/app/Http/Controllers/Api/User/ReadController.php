<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Role;

class ReadController extends Controller
{

    public function getList( Request $request )
    {
    	$limit  = $request->input('limit');
		$offset = $request->input('offset');

        $users = User::with('profile')
						->with('role')
						->with('avatar')
						->orderBy('id','DESC')
						->skip($offset)
						->take($limit)
						->get();

        return response()->json( [ 'result' => 'ok', 'users' => $users ]);
    }

	public function getListByRole( Request $request )
	{
		$limit  = $request->input('limit');
		$offset = $request->input('offset');

		$role   = Role::where( 'role', $request->input('role') )->first();

		if ( $role ) {

			$users = User::with('profile')
						->with('role')
						->with('avatar')
						->where( 'role_id', $role->id )
						->orderBy('id','DESC')
						->skip($offset)
						->take($limit)
						->get();

			return response()->json( [ 'result' => 'ok', 'users' => $users ]);
		}

		return $this->_sendJsonError( 'Users not found', 404 );
	}


    public function getDetail(Request $request, $id)
    {
        $user = User::find($id);

        if ( $user ) {
            $user->load([ 'profile', 'avatar' ]);
            return response()->json( [ 'result' => 'ok', 'user' => $user ]);
        }

        return $this->_sendJsonError( 'User not found', 404 );
    }

}
