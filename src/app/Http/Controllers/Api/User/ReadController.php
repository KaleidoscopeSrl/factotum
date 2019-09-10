<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Kaleidoscope\Factotum\User;
use Illuminate\Http\Request;

class ReadController extends Controller
{

    public function getList()
    {
        $users = User::with('profile')->with('role')->get();

        return response()->json( [ 'result' => 'ok', 'users' => $users ]);
    }


    public function getDetail(Request $request, $id)
    {
        $user = User::find($id);

        if ( $user ) {
            $user->load('profile');
            return response()->json( [ 'result' => 'ok', 'user' => $user ]);
        }

        return $this->_sendJsonError('Utente non trovato.');
    }

}
