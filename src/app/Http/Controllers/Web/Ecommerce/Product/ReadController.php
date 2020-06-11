<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Product;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Product;


class ReadController extends Controller
{

    public function getProductBySlug( Request $request, $productSlug )
    {
		$product = Product::where( 'url', $productSlug )->first();

        if ( $product ) {
			$product->load([ 'brand', 'product_category', 'tax' ]);

			$categories = array_reverse( $product->product_category->getFlatParentsArray() );

			return view('factotum::ecommerce.product')
								->with([
									'product'    => $product,
									'categories' => $categories
								]);
        }

		return view('factotum::errors.404');
    }

}
