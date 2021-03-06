<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\DiscountCode;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\DiscountCode;


class ReadController extends ApiBaseController
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

		$query->with('orders');
		$query->with('customer');
		$query->with('customer.profile');
		$query->orderBy($sort, $direction);

		$total = $query->count();

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$discountCodes = $query->get();

		return response()->json( [ 'result' => 'ok', 'discount_codes' => $discountCodes, 'total' => $total ]);
	}


	public function getList( Request $request, $eventId )
	{
		$discountCodes = DiscountCode::all();

		if ( $discountCodes->count() > 0 ) {
			return response()->json( [ 'result' => 'ok', 'discount_codes'  => $discountCodes ] );
		}

		return response()->json( [ 'result' => 'ok', 'discount_codes'  => [] ] );
	}


	public function getDetail(Request $request, $id)
	{
		$discountCode = DiscountCode::find( $id );

		if ( $discountCode ) {
			$discountCode->load('customer');
			$discountCode->load('customer.profile');
			$discountCode->load('orders');

			return response()->json( [ 'result' => 'ok', 'discount_code'  => $discountCode->toArray() ] );
		}

		return $this->_sendJsonError( 'Codice Sconto non trovato.' );
	}

}
