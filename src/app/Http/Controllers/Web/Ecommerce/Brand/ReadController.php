<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Brand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Lang;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Brand;


class ReadController extends Controller
{
	protected $_productsPerPage = 48;

    public function getProductsByBrand(Request $request, $brandUrl)
    {
    	$itemsPerPage    = $request->input('items_per_page', $this->_productsPerPage );
    	if ( !is_integer($itemsPerPage) ) {
			$itemsPerPage = $this->_productsPerPage;
		}
		$brandFilter     = $request->input('brand_filter');
		$brandsFilter    = $request->input('brands');
		$brand           = Brand::where( 'url', $brandUrl )->first();
		$brandsFiltered  = null;

		if ( $brandsFilter ) {
			$brandsFilter = explode(',', $brandsFilter);

			$brandsFiltered = Brand::whereIn('id', $brandsFilter)->get();
		}

        if ( $brand ) {
        	$brands = Brand::all();

			$query  = DB::table('products')
						->select('products.*', 'brands.name AS brand_name')
						->join('brands', 'brands.id', '=', 'products.brand_id');

			if ( !$brandsFilter ) {
				$brandsFilter[] = $brand->id;
				$query->where( 'brand_id', $brand->id );
			} else {
				$brandFilter = $brand->id;
				$query->whereIn( 'brand_id', $brandsFilter );
			}

			$products = $query->paginate($itemsPerPage);

			$view = 'factotum::ecommerce.product.products_by_brand';
			if ( file_exists( resource_path('views/ecommerce/product/products_by_brand.blade.php') ) ) {
				$view = 'ecommerce.product.products_by_brand';
			}

			return view( $view )
						->with([
							'metatags' => [
								'title'       => $brand->seo_title,
								'description' => $brand->seo_description
							],
							'itemsPerPage'         => $products->perPage(),
							'brandFilter'          => $brandFilter,
							'brandsFiltered'       => $brandsFiltered,
							'brand'                => $brand,
							'brandsFilter'         => $brandsFilter,
							'products'             => $products,
							'brands'               => $brands
						]);
        }

	    return response()->view( $this->_getNotFoundView() )->setStatusCode(404);
    }

}

