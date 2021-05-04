<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Order;
use Kaleidoscope\Factotum\OrderProduct;
use Kaleidoscope\Factotum\Traits\EcommerceUtils;


class ReadController extends Controller
{
	public function getList( Request $request )
	{
		try {
			$user   = Auth::user();
			$orders = Order::where( 'customer_id', $user->id )->orderBy('id', 'DESC')->get();

			$view = 'factotum::ecommerce.order.list';

			if ( file_exists( resource_path('views/ecommerce/order/list.blade.php') ) ) {
				$view = 'ecommerce.order.list';
			}

			if ( $orders ) {
				return view( $view )->with([
					'orders'   => $orders,
					'metatags' => [
						'title'       => Lang::get('factotum::ecommerce_order.order_list_title'),
						'description' => Lang::get('factotum::ecommerce_order.order_list_description')
					]
				]);
			}

			return view( $this->_getNotFoundView() );

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view( $this->_getServerErrorView() );
		}
	}


	public function getDetail( Request $request, $orderId )
	{
		try {
			$user  = Auth::user();
			$order = Order::where( 'customer_id', $user->id )->where('id', $orderId )->first();

			$view = 'factotum::ecommerce.order.detail';

			if ( file_exists( resource_path('views/ecommerce/order/detail.blade.php') ) ) {
				$view = 'ecommerce.order.detail';
			}

			if ( $order ) {
				$orderProducts = OrderProduct::with('product')->where( 'order_id', $order->id )->get();

				return view( $view )->with([
					'order'         => $order,
					'orderProducts' => $orderProducts,
					'metatags' => [
						'title'       => Lang::get('factotum::ecommerce_order.order_detail_title'),
						'description' => Lang::get('factotum::ecommerce_order.order_detail_description')
					]
				]);
			}

			return view( $this->_getNotFoundView() );

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view( $this->_getServerErrorView() );
		}
	}


	public function showThankyou( Request $request, $orderId )
	{
		try {
			if ( config('factotum.guest_cart') ) {
				$order = Order::find( $orderId );
			} else {
				$user  = Auth::user();
				$order = Order::where( 'customer_id', $user->id )->where('id', $orderId )->first();
			}

			$view = 'factotum::ecommerce.order.thank-you';

			if ( file_exists( resource_path('views/ecommerce/order/thank-you.blade.php') ) ) {
				$view = 'ecommerce.order.thank-you';
			}

			if ( $order ) {
				return view( $view )->with([
					'order'         => $order,
					'metatags' => [
						'title'       => Lang::get('factotum::ecommerce_order.thankyou_title'),
						'description' => Lang::get('factotum::ecommerce_order.thankyou_description')
					]
				]);
			}

			return view( $this->_getNotFoundView() );

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view( $this->_getServerErrorView() );
		}
	}
}