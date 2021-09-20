<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductAttributeValue;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreProductAttributeValue;
use Kaleidoscope\Factotum\Models\ProductAttributeValue;


class CreateController extends ApiBaseController
{

	public function create( StoreProductAttributeValue $request )
	{
		$data = $request->all();

		$productAttributeValue = new ProductAttributeValue;
		$productAttributeValue->fill( $data );
		$productAttributeValue->save();

		return response()->json( [ 'result' => 'ok', 'product_attribute_value'  => $productAttributeValue ] );
	}

}
