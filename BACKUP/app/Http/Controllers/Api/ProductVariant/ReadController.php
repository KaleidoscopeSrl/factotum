<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductVariant;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ProductVariant;


class ReadController extends ApiBaseController
{

	public function getList(Request $request, $productId)
	{
		$productVariants = ProductVariant::where('product_id', $productId)
											->orderBy('id','DESC')
											->get();

		return response()->json( [ 'result' => 'ok', 'product_variants' => $productVariants ]);
	}


	public function getListPaginated( Request $request, $productId )
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

		$query = ProductVariant::query();
		$query->where('product_id', $productId)
				->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$productVariants = $query->get();

		return response()->json( [ 'result' => 'ok', 'product_variants' => $productVariants, 'total' => ProductVariant::where('product_id', $productId)->count() ]);
	}


	public function getDetail(Request $request, $id)
	{
		$productVariant = ProductVariant::find($id);

		if ( $productVariant ) {
			return response()->json( [ 'result' => 'ok', 'product_variant'  => $productVariant ] );
		}

		return $this->_sendJsonError( 'Variante prodotto non trovata.', 404 );
	}

}
