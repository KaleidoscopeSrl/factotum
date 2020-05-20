<?php

namespace App\Http\Controllers\Api\DiscountCode;

use Illuminate\Http\Request;

use App\DiscountCode;

class ReadController extends Controller
{

	public function getList( Request $request, $eventId )
	{
		$discountCodes = DiscountCode::where( 'event_id', $eventId )->with('tickets')->get();

		if ( $discountCodes->count() > 0 ) {
			return response()->json( [ 'result' => 'ok', 'discount_codes'  => $discountCodes ] );
		}

		return response()->json( [ 'result' => 'ok', 'discount_codes'  => [] ] );
	}


	public function getDetail(Request $request, $id)
	{
		$discountCode = DiscountCode::find( $id );

		if ( $discountCode ) {
			$discountCode->load('tickets');
			return response()->json( [ 'result' => 'ok', 'discount_code'  => $discountCode->toArray() ] );
		}

		return $this->_sendJsonError( 'Codice Sconto non trovato.' );
	}

}
