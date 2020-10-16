<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Order;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Order;
use Kaleidoscope\Factotum\OrderProduct;


class ReadController extends Controller
{

    public function getListPaginated( Request $request )
    {
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort || $sort == 'id' ) {
			$sort = 'orders.id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Order::query();

		$rawQuery = 'orders.*, first_name, last_name, company_name, ';
		$rawQuery .= '(total_net+total_shipping' . ( config('factotum.product_vat_included') ? '' : '+total_tax' ) . ') AS total';

		$query->selectRaw( $rawQuery );
		$query->join('users', 'users.id', '=', 'orders.customer_id');
		$query->join('profiles', 'profiles.user_id', '=', 'users.id');

		$filtersActive = false;
		if ( isset($filters) && count($filters) > 0 ) {
			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$filtersActive = true;

				$query->whereRaw( 'LCASE(delivery_city) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(delivery_province) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(first_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(last_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(company_name) like "%' . $filters['term'] . '%"' );
			}

			if ( isset($filters['from_date']) ) {
				$filtersActive = true;

				$query->where('orders.created_at', '>=', $filters['from_date']);
			}

			if ( isset($filters['to_date']) ) {
				$filtersActive = true;

				$query->where('orders.created_at', '<=', $filters['to_date']);
			}
		}

		if ( $sort == 'customer' ) {

			$query->orderBy('last_name', $direction);
			$query->orderBy('first_name', $direction);
			$query->orderBy('company_name', $direction);

		} else if ( $sort == 'delivery' ) {

			$query->orderBy('delivery_city', $direction);
			$query->orderBy('delivery_province', $direction);
			$query->orderBy('delivery_country', $direction);

		} else if ( $sort == 'total' ) {

			$query->orderBy('total_net', $direction);

		} else {
			$query->orderBy($sort, $direction);
		}

		$total = $query->count();

        if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
        	$query->skip($offset);
		}

		$orders = $query->get();

        return response()->json( [ 'result' => 'ok', 'orders' => $orders, 'total' => $total ]);
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
        	$order->total = $order->total_net + ( config('factotum.product_vat_included') ? 0 : $order->total_tax ) + $order->total_shipping;
			$order->load([ 'customer', 'customer.profile' ]);
			$order->products = OrderProduct::with([ 'product', 'product_variant' ])
											->where( 'order_id', $order->id )
											->get();

            return response()->json( [ 'result' => 'ok', 'order' => $order ]);
        }

        return $this->_sendJsonError( 'Order not found', 404 );
    }

}
