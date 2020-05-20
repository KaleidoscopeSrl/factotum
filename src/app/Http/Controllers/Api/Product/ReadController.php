<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Product;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\Media;


class ReadController extends Controller
{

    public function getListPaginated( Request $request )
    {
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Product::with([ 'brand', 'category', 'supplier' ]);


		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(code) like "%' . $filters['term'] . '%"' );
			}

			if ( isset($filters['category_id']) && $filters['category_id'] ) {
				$category   = Category::find( $filters['category_id'] );
				$categories = $category->getFlatChildsArray();
				$tmp = [ $category->id ];

				if ( count($categories) > 0 ) {
					foreach ( $categories as $c ) {
						$tmp[] = $c->id;
					}
				}

				$tmp = array_unique( $tmp );
				$query->whereIn( 'category_id', $tmp );
			}

			if ( isset($filters['brand_id']) && $filters['brand_id'] ) {
				$query->whereIn('brand_id', $filters['brand_id']);
			}

			if ( isset($filters['supplier_id']) && $filters['supplier_id'] ) {
				$query->where('supplier_id', $filters['supplier_id']);
			}

			if ( isset($filters['active']) && $filters['active'] ) {
				$query->where('active', true );
			}

			if ( isset($filters['new']) && $filters['new'] ) {
				$query->where('status', 'C' );
			}

		}

		$query->orderBy($sort, $direction);

        if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
        	$query->skip($offset);
		}

		$products = $query->get();

        return response()->json( [ 'result' => 'ok', 'products' => $products ]);
    }


    public function getList( Request $request )
	{
		$products = Product::orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'products' => $products ]);
	}


    public function getDetail(Request $request, $id)
    {
		$product = Product::find($id);

        if ( $product ) {
			$product->load([ 'brand', 'category', 'supplier' ]);
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
