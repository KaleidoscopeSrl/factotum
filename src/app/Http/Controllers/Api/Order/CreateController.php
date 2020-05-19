<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Order;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreOrder;
use Kaleidoscope\Factotum\Order;
use Kaleidoscope\Factotum\OrderProduct;


class CreateController extends Controller
{

	public function create(StoreOrder $request)
	{
		$data = $request->all();

		$order = new Order;
		$order->fill( $data );
		$order->save();

		if ( count( $data['products'] ) > 0 ) {

			foreach ( $data['products'] as $row ) {
				$prodOrd = new OrderProduct;
				$prodOrd->order_id   = $order->id;
				$prodOrd->product_id = $row['product_id'];
				$prodOrd->quantity   = $row['quantity'];
				$prodOrd->save();
			}

		}

		return response()->json( [ 'result' => 'ok', 'order'  => $order->toArray() ] );
	}

}
