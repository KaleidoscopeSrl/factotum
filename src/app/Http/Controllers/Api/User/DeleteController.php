<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Content;

class DeleteController extends Controller
{

    public function remove(Request $request, $id)
    {

        $this->validator($request->all())->validate();

        $reassigningUser = $request->input('reassigned_user');

        Content::where('user_id', $id)
            ->update(['user_id' => $reassigningUser]);


        $user = User::find( $id );

        if ( $user ) {
            $deletedRows = $user->delete();

            if ( $deletedRows > 0 ) {
                return response()->json( [ 'result' => 'ok' ]);
            }
            return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
        }

        return $this->_sendJsonError( 'Utente non trovato.' );
    }

	protected function validator( array $data, $userId = false )
	{
		$rules = array(
			'reassigned_user' => 'required',
		);
		return Validator::make($data, $rules);
	}
}
