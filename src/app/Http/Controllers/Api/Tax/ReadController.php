<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tax;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Tax;

class ReadController extends Controller
{

	public function getList()
	{
		$taxes = Tax::orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'taxes' => $taxes ]);
	}


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

		$query = Tax::query();


		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(description) like "%' . $filters['term'] . '%"' );
			}

		}

		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$taxes = $query->get();

		return response()->json( [ 'result' => 'ok', 'taxes' => $taxes ]);
	}


	public function getDetail(Request $request, $id)
	{
		$tax = Tax::find($id);

		if ( $tax ) {
			return response()->json( [ 'result' => 'ok', 'tax' => $tax ]);
		}

		return $this->_sendJsonError( 'Tassa non trovata.', 404 );
	}

}
