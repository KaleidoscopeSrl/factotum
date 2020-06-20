<?php

namespace Kaleidoscope\Factotum\Observers;

use Kaleidoscope\Factotum\Order;

class OrderObserver
{
	/**
	 * Listen to the Order created event.
	 *
	 * @param  Order  $order
	 * @return void
	 */
	public function created(Order $order)
	{
	}



	/**
	 * Listen to the Order updated event.
	 *
	 * @param  Order $order
	 * @return void
	 */
	public function updated(Order $order)
	{
		if ( $order->payment_type == 'stripe' && $order->transaction_id && $order->status == 'new_order' ) {
			$order->sendNewOrderNotifications();
		}

		if ( $order->payment_type == 'paypal' && $order->transaction_id && $order->status == 'new_order' ) {
			$order->sendNewOrderNotifications();
		}

		if ( $order->status == 'waiting_payment' && ( $order->payment_type == 'bank-transfer' || $order->payment_type == 'custom-payment' ) ) {
			$order->sendNewOrderNotifications();
		}
	}


}