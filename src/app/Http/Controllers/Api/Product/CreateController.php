<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Product;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreProduct;
use Kaleidoscope\Factotum\Product;


class CreateController extends Controller
{

	public function create(StoreProduct $request)
	{
		$data = $request->all();

		$product = new Product;
		$product->fill( $data );
		$product->save();

		return response()->json( [ 'result' => 'ok', 'product'  => $product->toArray() ] );
	}

}
