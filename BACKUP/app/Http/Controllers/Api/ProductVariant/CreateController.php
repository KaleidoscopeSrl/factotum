<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductVariant;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreProductVariant;
use Kaleidoscope\Factotum\Models\ProductVariant;


class CreateController extends ApiBaseController
{

	public function create( StoreProductVariant $request )
	{
		$data = $request->all();

		$productVariant = new ProductVariant;
		$productVariant->fill( $data );
		$productVariant->save();

		return response()->json( [ 'result' => 'ok', 'product_variant'  => $productVariant ] );
	}

}
