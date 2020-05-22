<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\DiscountCode;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\DiscountCode;


class ReadController extends Controller
{

	public function getListPaginated( Request $request )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = DiscountCode::query();


		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(code) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(discount) like "%' . $filters['term'] . '%"' );
			}

		}

		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$products = $query->get();

		return response()->json( [ 'result' => 'ok', 'discount_codes' => $products ]);
	}


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
			$discountCode->load('products');
			return response()->json( [ 'result' => 'ok', 'discount_code'  => $discountCode->toArray() ] );
		}

		return $this->_sendJsonError( 'Codice Sconto non trovato.' );
	}

}
