<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductAttribute;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ProductAttribute;


class ReadController extends ApiBaseController
{

	public function getList( Request $request )
	{
		$productAttributes = ProductAttribute::orderBy('id','DESC')->get();

		return response()->json( [ 'result' => 'ok', 'product_attributes' => $productAttributes ]);
	}


	public function getListPaginated( Request $request )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');


		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = ProductAttribute::query();
		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$productAttributes = $query->get();

		return response()->json( [
			'result'             => 'ok',
			'product_attributes' => $productAttributes,
			'total'              => ProductAttribute::count()
		]);
	}


	public function getDetail(Request $request, $id)
	{
		$productAttribute = ProductAttribute::find($id);

		if ( $productAttribute ) {
			return response()->json( [ 'result' => 'ok', 'product_attribute'  => $productAttribute ] );
		}

		return $this->_sendJsonError( 'Attributo prodotto non trovato.', 404 );
	}

}
