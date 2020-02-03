<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Capability;

class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
		$capability = Capability::find($id);

		if ( $capability ) {

			$deletedRows = $capability->delete();

			if ( $deletedRows > 0 ) {
				return response()->json(['result' => 'ok']);
			}

			return $this->_sendJsonError('Errore in fase di cancellazione.');
		}

		return $this->_sendJsonError( 'Capability not found', 404 );
	}

}
