<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\ProductCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\Brand;

class ReadController extends Controller
{

    public function getProductsByCategory(Request $request, $productCategorySlug)
    {
    	$itemsPerPage    = $request->input('items_per_page', 12);
		$brandFilter     = $request->input('brand_filter');
		$productCategory = ProductCategory::where('name', $productCategorySlug)->first();

        if ( $productCategory ) {
        	$brands   = Brand::all();
			$query = DB::table('products')->where('product_category_id', $productCategory->id);

			if ( $brandFilter ) {
				$query->where( 'brand_id', $brandFilter );
			}

			$products = $query->paginate($itemsPerPage);

			return view('factotum::ecommerce.products_by_category')
						->with([
							'itemsPerPage'    => $products->perPage(),
							'brandFilter'     => $brandFilter,
							'productCategory' => $productCategory,
							'products'        => $products,
							'brands'          => $brands
						]);
        }

        return view('factotum::errors.404');
    }

}

