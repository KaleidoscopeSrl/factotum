<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Kaleidoscope\Factotum\User;
use Illuminate\Http\Request;

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
