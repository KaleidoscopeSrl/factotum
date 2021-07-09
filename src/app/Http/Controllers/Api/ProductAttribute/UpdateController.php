<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductAttribute;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreProductAttribute;
use Kaleidoscope\Factotum\Models\ProductAttribute;


class UpdateController extends ApiBaseController
{

	public function update(StoreProductAttribute $request, $id)
	{
		$data = $request->all();

		$productAttribute = ProductAttribute::find( $id );
		$productAttribute->fill( $data );
		$productAttribute->save();

		return response()->json( [ 'result' => 'ok', 'product_attribute'  => $productAttribute ] );
	}

}
