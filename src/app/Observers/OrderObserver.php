<?php

namespace Kaleidoscope\Factotum\Observers;

use Kaleidoscope\Factotum\Order;

class OrderObserver
{

	public function updating( Order $order )
	{
		if ( $order->isDirty('status') ) {
			$newStatus = $order->status;
			$oldStatus = $order->getOriginal('status');

			if ( $newStatus != $oldStatus ) {
				$order->sendOrderStatusChangeNotification();
			}
		}
	}

}