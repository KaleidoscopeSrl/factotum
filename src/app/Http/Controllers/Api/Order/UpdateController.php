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

}
