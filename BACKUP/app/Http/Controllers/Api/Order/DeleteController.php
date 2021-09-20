<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Order;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Order;


class DeleteController extends ApiBaseController
{

	public function remove(Request $request, $id)
	{
		$order = Order::find( $id );

		if ( $order ) {
			$deletedRows = $order->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Order not found', 404 );
	}


	public function removeOrders(Request $request)
	{
		$orders = $request->input('orders');

		if ( $orders && count($orders) > 0 ) {
			Order::whereIn( 'id', $orders )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
