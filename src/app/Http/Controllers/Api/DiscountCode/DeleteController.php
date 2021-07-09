<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\DiscountCode;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\DiscountCode;


class DeleteController extends ApiBaseController
{

	public function remove(Request $request, $id)
	{
		$discountCode = DiscountCode::find( $id );

		if ( $discountCode ) {
			$deletedRows = $discountCode->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Discount Code not found', 404 );
	}


	public function removeDiscountCodes(Request $request)
	{
		$discountCodes = $request->input('discountCodes');

		if ( $discountCodes && count($discountCodes) > 0 ) {
			DiscountCode::whereIn( 'id', $discountCodes )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
