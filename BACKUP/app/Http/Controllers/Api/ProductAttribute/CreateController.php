<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductAttribute;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreProductAttribute;
use Kaleidoscope\Factotum\Models\ProductAttribute;


class CreateController extends ApiBaseController
{

	public function create( StoreProductAttribute $request )
	{
		$data = $request->all();

		$productAttribute = new ProductAttribute;
		$productAttribute->fill( $data );
		$productAttribute->save();

		return response()->json( [ 'result' => 'ok', 'product_attribute'  => $productAttribute ] );
	}

}
