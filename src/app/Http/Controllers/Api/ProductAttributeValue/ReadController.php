<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductAttributeValue;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ProductAttributeValue;


class ReadController extends ApiBaseController
{

	public function getList( Request $request, $productAttributeId )
	{
		$productAttributeValues = ProductAttributeValue::where('product_attribute_id', $productAttributeId)
														->orderBy('id','DESC')
														->get();

		return response()->json( [ 'result' => 'ok', 'product_attribute_values' => $productAttributeValues ]);
	}


	public function getListPaginated( Request $request, $productAttributeId )
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

		$query = ProductAttributeValue::query();
		$query->where('product_attribute_id', $productAttributeId);
		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$productAttributeValues = $query->get();

		return response()->json( [
			'result'                   => 'ok',
			'product_attribute_values' => $productAttributeValues,
			'total'                    => ProductAttributeValue::where('product_attribute_id', $productAttributeId)->count()
		]);
	}


	public function getFilteredList( Request $request, $productAttributeId )
	{
		$term = $request->input('term');
		$query = ProductAttributeValue::query();
		$query->where('product_attribute_id', $productAttributeId);

		if ( $term ) {
			$query->whereRaw('label LIKE "%' . $term . '%"');
		}

		$query->orderBy('label', 'ASC');

		$productAttributeValues = $query->get();

		return response()->json( [
			'result'                   => 'ok',
			'product_attribute_values' => $productAttributeValues
		]);
	}


	public function getDetail(Request $request, $id)
	{
		$productAttributeValue = ProductAttributeValue::find($id);

		if ( $productAttributeValue ) {
			return response()->json( [ 'result' => 'ok', 'product_attribute_value'  => $productAttributeValue ] );
		}

		return $this->_sendJsonError( 'Valore Attributo prodotto non trovato.', 404 );
	}

}
