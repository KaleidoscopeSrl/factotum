<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Product;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Kaleidoscope\Factotum\Http\Requests\StoreProduct;
use Kaleidoscope\Factotum\Product;


class CreateController extends Controller
{

	public function create( StoreProduct $request )
	{
		$data = $request->all();

		$product = new Product;
		$product->fill( $data );
		$product->save();

		return response()->json( [ 'result' => 'ok', 'product'  => $product->toArray() ] );
	}


	public function duplicate( Request $request, $productId )
	{
		$product = Product::find( $productId );
		$newProduct = $product->replicate();

		$productCode = substr( $newProduct->code . '_2', 0, 16);
		$absUrl      = $newProduct->abs_url . '-clone-2';

		$productExist = Product::withTrashed()->where('code', $productCode)->first();
		if ( $productExist ) {
			$productCode .= '_' . Str::random(5);
			$absUrl      .= '_' . Str::random(5);
		}

		$newProduct->code    = $productCode;
		$newProduct->name    = $product->name . ' clone';
		$newProduct->abs_url = $absUrl;
		$newProduct->active  = 0;
		$newProduct->save();

		return response()->json( [ 'result' => 'ok', 'product'  => $newProduct->toArray() ] );
	}

}
