<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Checkout;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\CustomerAddress;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Http\Requests\SetDeliveryAddress;
use Kaleidoscope\Factotum\Http\Requests\SetInvoiceAddress;
use Kaleidoscope\Factotum\Http\Requests\SetShipping;

use Kaleidoscope\Factotum\Traits\CartUtils;


class UpdateController extends Controller
{

	use CartUtils;


    public function setDeliveryAddress( SetDeliveryAddress $request )
    {
		try {
			$user      = Auth::user();
			$addressId = $request->input('address_id');

			$deliveryAddress = CustomerAddress::where('customer_id', $user->id)
												->where('type', 'delivery')
												->where('id', $addressId)
												->first();

			if ( $deliveryAddress ) {
				$request->session()->put( 'delivery_address', $deliveryAddress->id );

				$request->session()->remove('shipping');
				$shippingOptions = $this->_getShippingOptions();

				$view = 'factotum::ecommerce.ajax.shipping-options';
				if ( file_exists( resource_path('views/ecommerce/ajax/shipping-options.blade.php') ) ) {
					$view = 'ecommerce.ajax.shipping-options';
				}


				return $request->wantsJson() ? json_encode([
					'result'           => 'ok',
					'shipping_options' => view( $view )->with([ 'shippingOptions' => $shippingOptions ])->render()
				]) : redirect()->back();
			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko' ]) : view('factotum::errors.500');

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view('factotum::errors.500');
		}
    }


	public function setInvoiceAddress( SetInvoiceAddress $request )
	{
		try {
			$user      = Auth::user();
			$addressId = $request->input('address_id');

			$invoiceAddress = CustomerAddress::where('customer_id', $user->id)
												->where('type', 'invoice')
												->where('id', $addressId)
												->first();

			if ( $invoiceAddress ) {
				$request->session()->put('invoice_address', $invoiceAddress->id );

				return $request->wantsJson() ? json_encode([ 'result' => 'ok' ]) : redirect()->back();
			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko' ]) : view('factotum::errors.500');

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view('factotum::errors.500');
		}
	}


	public function setShipping( SetShipping $request )
	{
		try {
			$shipping = $request->input('shipping');
			$request->session()->put('shipping', $shipping );

			$cart   = $this->_getCart();
			$totals = $this->_getCartTotals($cart);

			$result = [
				'result'        => 'ok',
				'shipping'      => true,

				'totalProducts' => $totals['totalProducts'],
				'totalPartial'  => '€ ' . number_format( $totals['totalPartial'], 2, ',', '.' ),
				'totalTaxes'    => '€ ' . number_format( $totals['totalTaxes'], 2, ',', '.' ),
				'totalShipping' => ( $totals['totalShipping'] ? '€ ' . number_format( $totals['totalShipping'], 2, ',', '.' ) : '-' ),
				'total'         => '€ ' . number_format( $totals['total'], 2, ',', '.' ),
			];

			return $request->wantsJson() ? json_encode( $result ) : redirect()->back();
		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view('factotum::errors.500');
		}
	}


}
