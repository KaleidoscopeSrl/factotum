<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductAttributeValue;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreProductAttributeValue;
use Kaleidoscope\Factotum\Models\ProductAttributeValue;


class UpdateController extends ApiBaseController
{

	public function update( StoreProductAttributeValue $request, $id )
	{
		$data = $request->all();

		$productAttributeValue = ProductAttributeValue::find( $id );
		$productAttributeValue->fill( $data );
		$productAttributeValue->save();

		return response()->json( [ 'result' => 'ok', 'product_attribute_value'  => $productAttributeValue ] );
	}

}
