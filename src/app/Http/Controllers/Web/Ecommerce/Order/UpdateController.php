<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Order;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Http\Requests\SetOrderTransaction;

use Kaleidoscope\Factotum\Order;
use Kaleidoscope\Factotum\Traits\CartUtils;


class UpdateController extends Controller
{

	use CartUtils;

    public function setOrderTransaction( SetOrderTransaction $request )
    {
		try {
			$user          = Auth::user();
			$orderId       = $request->input('order_id');
			$transactionId = $request->input('transaction_id');

			$order = Order::where('customer_id', $user->id)
							->where('id', $orderId)
							->first();

			if ( $order ) {
				$order->setTransactionId( $transactionId );
				$cart = $this->_getCart();

				$result = [
					'result'   => 'ok',
					'order_id' => $order->id,
					'redirect' => url('/order/thank-you/' . $order->id )
				];

				return $request->wantsJson() ? json_encode($result) : redirect()->back();
			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko' ]) : view($this->_getServerErrorView());

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
		}
    }



}
