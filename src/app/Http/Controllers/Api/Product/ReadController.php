<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Product;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Product;
use Kaleidoscope\Factotum\Models\ProductCategory;


class ReadController extends ApiBaseController
{

    public function getListPaginated( Request $request )
    {
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);
		$lang      = $request->input('lang');


		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Product::with([ 'brand', 'product_categories', 'product_categories.parent' ]);

		if ( $lang ) {
			$query->where( 'lang', $lang );
		}

		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(code) like "%' . $filters['term'] . '%"' );
			}

			if ( isset($filters['product_category_id']) && $filters['product_category_id'] ) {
				$productCategory   = ProductCategory::find( $filters['product_category_id'] );
				$productCategories = $productCategory->getFlatChildsArray();
				$tmp = [ $productCategory->id ];

				if ( count($productCategories) > 0 ) {
					foreach ( $productCategories as $c ) {
						$tmp[] = $c->id;
					}
				}

				$tmp = array_unique( $tmp );

				$query->whereHas('product_categories', function ($q) use ($tmp) {
					$q->whereIn('product_category_id', $tmp);
				});
			}

			if ( isset($filters['brand_id']) && $filters['brand_id'] ) {
				$query->whereIn('brand_id', $filters['brand_id']);
			}

			if ( isset($filters['active']) && $filters['active'] ) {
				$query->where('active', true );
			}

			if ( isset($filters['featured']) && $filters['featured'] ) {
				$query->where('featured', true );
			}

		}

		$total = $query->count();

		$query->orderBy($sort, $direction);

        if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
        	$query->skip($offset);
		}

		$products = $query->get();

        return response()->json( [ 'result' => 'ok', 'products' => $products, 'total' => $total ]);
    }


    public function getList( Request $request )
	{
		$products = Product::orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'products' => $products ]);
	}


	public function getListBySearch( Request $request )
	{
		$search = $request->input('search');

		$query = Product::where( 'name', 'like', '%' . $search . '%' )
						->orWhere( 'code', 'like', '%' . $search . '%'  );

		$productList = $query->get();

		return response()->json( [
			'result'   => 'ok',
			'products' => $productList
		]);
	}


    public function getDetail(Request $request, $id)
    {
		$product = Product::find($id);

        if ( $product ) {
			$product->load([ 'brand', 'product_categories', 'tax', 'product_variants' ]);
            return response()->json( [ 'result' => 'ok', 'product' => $product ]);
        }

        return $this->_sendJsonError( 'Product not found', 404 );
    }


	public function getNumberByStatus( Request $request )
	{
		$totalActive    = Product::where('active', 1)->count();
		$totalNotActive = Product::whereNull('active')->orWhere('active', 0)->count();

		return response()->json( [
			'result' => 'ok',
			'active' => $totalActive,
			'not_active' => $totalNotActive
		]);
	}

}
