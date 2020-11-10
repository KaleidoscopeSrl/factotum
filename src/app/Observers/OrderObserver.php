<?php

namespace Kaleidoscope\Factotum\Observers;

use Kaleidoscope\Factotum\Invoice;
use Kaleidoscope\Factotum\Order;

class OrderObserver
{

	public function created( Order $order )
	{
		$invoice           = new Invoice();
		$invoice->order_id = $order->id;

		if ( Invoice::count() == 0 ) {
			$invoice->number = config('factotum.invoice_start_number', 1);
		} else {
			$lastInvoice = Invoice::latest('id')->first();
			$invoice->number = $lastInvoice->number + 1;
		}

		$invoice->total_net          = $order->total_net;
		$invoice->total_tax          = $order->total_tax;
		$invoice->total_shipping_net = $order->total_shipping_net;
		$invoice->total_shipping_tax = $order->total_shipping_tax;
		$invoice->shop_address   = env('SHOP_OWNER_ADDRESS');
		$invoice->save();
	}


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