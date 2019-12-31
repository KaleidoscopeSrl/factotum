<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\Http\Requests\DeleteUser;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Content;

class DeleteController extends Controller
{

	public function remove(DeleteUser $request, $id)
	{
		$reassigningUser = $request->input('reassigned_user');

		Content::where('user_id', $id)
				->update(['user_id' => $reassigningUser]);

		$user = User::find( $id );

		if ( $user ) {

			// Rimuovo il file dell'avatar
			$filename = basename( $user->avatar );
			if ( Storage::exists( 'avatars/' . $filename) ) {
				Storage::delete( 'avatars/' . $filename);
			}

			$deletedRows = $user->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Utente non trovato.' );
	}

}
