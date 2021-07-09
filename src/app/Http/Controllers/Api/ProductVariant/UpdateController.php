<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductVariant;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreProductVariant;
use Kaleidoscope\Factotum\Models\ProductVariant;


class UpdateController extends ApiBaseController
{

	public function update(StoreProductVariant $request, $id)
	{
		$data = $request->all();

		$productVariant = ProductVariant::find( $id );
		$productVariant->fill( $data );
		$productVariant->save();

		return response()->json( [ 'result' => 'ok', 'product_variant'  => $productVariant ] );
	}

}
