<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Content;


class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
		$reassigningUser = $request->input('reassigned_user');

		if ( $reassigningUser ) {
			Content::where('user_id', $id)->update(['user_id' => $reassigningUser]);
		}

		$user = User::find( $id );

		if ( $user ) {

			$deletedRows = $user->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'User not found', 404 );
	}


	public function removeUsers(Request $request)
	{
		$user  = Auth::user();
		$users = $request->input('users');

		if ( $users && count($users) > 0 ) {
			foreach ( $users as $userID ) {
				$userOnEdit = User::find($userID);
				if ( $userOnEdit->editable || (!$userOnEdit->editable && $user->isAdmin()) ) {
					$userOnEdit->delete();
				}
			}
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
