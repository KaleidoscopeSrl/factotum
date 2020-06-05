<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Product;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;


class ReadController extends Controller
{

    public function getProductBySlug( Request $request, $productSlug )
    {
		$product = Product::where( 'url', $productSlug )->first();

        if ( $product ) {
			$product->load([ 'brand', 'product_category', 'tax' ]);

			return view('factotum::ecommerce.product')
								->with(['product' => $product ]);
        }

		return redirect('/404', 404);
    }

}
