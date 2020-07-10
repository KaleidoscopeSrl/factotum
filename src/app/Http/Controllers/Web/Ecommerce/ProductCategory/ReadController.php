<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\ProductCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\Brand;

class ReadController extends Controller
{
	protected $_productsPerPage = 48;

    public function getProductsByCategory(Request $request, $productCategorySlug)
    {
    	$itemsPerPage    = $request->input('items_per_page', $this->_productsPerPage );
		$brandFilter     = $request->input('brand_filter');
		$brandsFilter    = $request->input('brands');
		$productCategory = ProductCategory::where('name', $productCategorySlug)->first();

		$tmp = [ $productCategory->id ];
		$childs = $productCategory->singleCategoryFlatTreeChildsArray( null, null );

		if ( $childs && count($childs) > 0 ) {
			foreach ( $childs as $c ) {
				$tmp[] = $c->id;
			}
		}

		if ( $brandsFilter ) {
			$brandsFilter = explode(',', $brandsFilter);
		}

        if ( $productCategory ) {
        	$brands = Brand::orderBy('name', 'asc')->get();

			$query  = DB::table('products')
						->select('products.*', 'brands.name AS brand_name')
						->join('brands', 'brands.id', '=', 'products.brand_id')
						->whereIn('product_category_id', $tmp);

			if ( $brandFilter ) {
				$query->where( 'brand_id', $brandFilter );
			}

			if ( $brandsFilter ) {
				$query->whereIn( 'brand_id', $brandsFilter );
			}

			$query->whereNull('products.deleted_at');

//			if ( env('APP_DEBUG') ) {
//				echo Utility::getSqlQuery($query);
//			}

			$products = $query->paginate($itemsPerPage);

			$view = 'factotum::ecommerce.product.products_by_category';

			if ( file_exists( resource_path('views/ecommerce/product/products_by_category.blade.php') ) ) {
				$view = 'ecommerce.product.products_by_category';
			}

			return view( $view )
						->with([
							'itemsPerPage'         => $products->perPage(),
							'brandFilter'          => $brandFilter,
							'productCategory'      => $productCategory,
							'brandsFilter'         => $brandsFilter,
							'products'             => $products,
							'brands'               => $brands
						]);
        }

        return view( $this->_getNotFoundView() );
    }

}

