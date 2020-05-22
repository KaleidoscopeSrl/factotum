<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Product;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreProduct;
use Kaleidoscope\Factotum\Product;


class UpdateController extends Controller
{

	public function update(StoreProduct $request, $id)
	{
		$data = $request->all();

		$product = Product::find($id);
		$product->fill( $data );
		$product->save();

        return response()->json( [ 'result' => 'ok', 'product'  => $product->toArray() ] );
	}


	public function changeProductsStatus(Request $request)
	{
		$products = $request->input('products');
		$active   = $request->input('active');

		if ( $products && count($products) > 0 ) {
			foreach ( $products as $prodId ) {
				$prod = Product::find($prodId);
				$prod->active = $active;
				$prod->save();
			}
		}

		return response()->json( [ 'result' => 'ok' ] );
	}


	public function changeProductsCategory(Request $request)
	{
		$products   = $request->input('products');
		$categoryId = $request->input('category_id');

		if ( $products && count($products) > 0 ) {
			foreach ( $products as $prodId ) {
				$prod = Product::find($prodId);
				$prod->product_category_id = $categoryId;
				$prod->save();
			}
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
