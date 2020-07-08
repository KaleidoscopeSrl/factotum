<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Brand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Brand;


class ReadController extends Controller
{
	protected $_productsPerPage = 48;

    public function getProductsByBrand(Request $request, $brandCode)
    {
    	$itemsPerPage    = $request->input('items_per_page', $this->_productsPerPage );
		$brandFilter     = $request->input('brand_filter');
		$brandsFilter    = $request->input('brands');
		$brand           = Brand::where( 'code', $brandCode )->first();
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
							'itemsPerPage'         => $products->perPage(),
							'brandFilter'          => $brandFilter,
							'brandsFiltered'       => $brandsFiltered,
							'brand'                => $brand,
							'brandsFilter'         => $brandsFilter,
							'products'             => $products,
							'brands'               => $brands
						]);
        }

        return view( $this->_getNotFoundView() );
    }

}

