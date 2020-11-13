<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Product;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreProduct;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\ProductProductCategory;


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


	public function changeProductsCategories(Request $request)
	{
		$products   = $request->input('products');
		$categories = $request->input('product_category_ids');

		if ( $products && count($products) > 0 ) {
			foreach ( $products as $product ) {
				$product = Product::find($product);
				$product->save();
			}
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
