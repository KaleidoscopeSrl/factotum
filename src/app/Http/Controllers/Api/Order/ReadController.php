<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Order;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Order;


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

		$query = Order::with([ 'customer' ]);

//		if ( isset($filters) && count($filters) > 0 ) {
//			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
//				$query->whereRaw( 'LCASE(name) like "%' . $filters['term'] . '%"' );
//				$query->orWhereRaw( 'LCASE(code) like "%' . $filters['term'] . '%"' );
//			}
//
//			if ( isset($filters['brand_id']) && $filters['brand_id'] ) {
//				$query->whereIn('brand_id', $filters['brand_id']);
//			}
//		}

		$query->orderBy($sort, $direction);

        if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
        	$query->skip($offset);
		}

		$orders = $query->get();

        return response()->json( [ 'result' => 'ok', 'orders' => $orders ]);
    }


    public function getList( Request $request )
	{
		$orders = Order::orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'orders' => $orders ]);
	}


    public function getDetail(Request $request, $id)
    {
		$order = Order::find($id);

        if ( $order ) {
			$order->load([ 'customer', 'products' ]);
            return response()->json( [ 'result' => 'ok', 'order' => $order ]);
        }

        return $this->_sendJsonError( 'Order not found', 404 );
    }

}
