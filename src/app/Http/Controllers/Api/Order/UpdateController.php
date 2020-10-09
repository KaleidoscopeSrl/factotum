<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Order;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreOrder;
use Kaleidoscope\Factotum\Order;


class UpdateController extends Controller
{

	public function update(StoreOrder $request, $id)
	{
		$data = $request->all();

		$order = Order::find($id);
		$order->fill( $data );
		$order->save();

        return response()->json( [ 'result' => 'ok', 'order'  => $order->toArray() ] );
	}


	public function changeOrdersStatus(Request $request)
	{
		$orders = $request->input('orders');
		$status = $request->input('status');

		if ( $orders && count($orders) > 0 ) {
			foreach ( $orders as $orderId ) {
				$order = Order::find($orderId);
				if ( $order ) {
					$order->status = $status;
					$order->save();
				}
			}
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
