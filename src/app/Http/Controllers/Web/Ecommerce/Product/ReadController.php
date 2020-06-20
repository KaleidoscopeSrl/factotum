<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Product;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Http\Requests\SearchProduct;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;


class ReadController extends Controller
{

    public function getProductBySlug( Request $request, $productSlug )
    {
		$product = Product::where( 'url', $productSlug )->first();

        if ( $product ) {
			$product->load([ 'brand', 'product_category', 'tax' ]);

			$categories = array_reverse( $product->product_category->getFlatParentsArray() );

			$view = 'factotum::ecommerce.product.product';
			if ( file_exists( resource_path('views/ecommerce/product/product.blade.php') ) ) {
				$view = 'ecommerce.product.product';
			}

			return view( $view )->with([
									'product'    => $product,
									'categories' => $categories
								]);
        }

		return view( $this->_getNotFoundView() );
    }


	public function showSearchProduct( Request $request )
	{
		$view = 'factotum::ecommerce.product.search-product';
		if ( file_exists( resource_path('views/ecommerce/product/search-product.blade.php') ) ) {
			$view = 'ecommerce.product.search-product';
		}

		return view( $view )->with([
			'metatags' => [
				'title'       => Lang::get('factotum::ecommerce_product.product_search_title'),
				'description' => Lang::get('factotum::ecommerce_product.product_search_description')
			],
			'products' => new Collection([])
		]);
	}


    public function searchProduct( SearchProduct $request )
	{
		$view = 'factotum::ecommerce.product.search-product';
		if ( file_exists( resource_path('views/ecommerce/product/search-product.blade.php') ) ) {
			$view = 'ecommerce.product.search-product';
		}

		$term              = $request->input('term');
		$productCategoryId = $request->input('product_category_id', null);

		$query = Product::query();

		if ( $term ) {
			$query->whereRaw( '( LCASE(name) like "%' . $term . '%" OR LCASE(code) like "%' . $term . '%" ) ' );
		}

		if ( $productCategoryId ) {
			$productCategory   = ProductCategory::find( $productCategoryId );
			$productCategories = $productCategory->getFlatChildsArray();
			$tmp = [ $productCategory->id ];

			if ( count($productCategories) > 0 ) {
				foreach ( $productCategories as $c ) {
					$tmp[] = $c->id;
				}
			}

			$tmp = array_unique( $tmp );
			$query->whereIn( 'product_category_id', $tmp );
		}

		$products = $query->get();

		return view( $view )->with([
			'metatags' => [
				'title'       => Lang::get('factotum::ecommerce_product.product_search_title'),
				'description' => Lang::get('factotum::ecommerce_product.product_search_description')
			],
			'term'                => $term,
			'product_category_id' => $productCategoryId,
			'products'            => ( $products && $products->count() > 0 ? $products->toArray() : [] )
		]);
	}

}
