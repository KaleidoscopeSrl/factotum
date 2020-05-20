<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tax;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Tax;

class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
		$tax = Tax::find( $id );

		if ( $tax ) {
			$deletedRows = $tax->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Tax not found', 404 );
	}


	public function removeTaxes(Request $request)
	{
		$taxes = $request->input('taxes');

		if ( $taxes && count($taxes) > 0 ) {
			Tax::whereIn( 'id', $taxes )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
