<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductVariant;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreProductVariant;
use Kaleidoscope\Factotum\ProductVariant;


class CreateController extends Controller
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
