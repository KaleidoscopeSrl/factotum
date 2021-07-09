<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Checkout;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Http\Requests\SetDeliveryAddress;
use Kaleidoscope\Factotum\Http\Requests\SetInvoiceAddress;
use Kaleidoscope\Factotum\Http\Requests\SetShipping;
use Kaleidoscope\Factotum\Http\Requests\ProceedCheckout;
use Kaleidoscope\Factotum\Http\Requests\StoreGuestCustomerDeliveryAddress;
use Kaleidoscope\Factotum\Http\Requests\StoreGuestCustomerInvoiceAddress;
use Kaleidoscope\Factotum\Traits\EcommerceUtils;
use Kaleidoscope\Factotum\Models\Profile;
use Kaleidoscope\Factotum\Models\User;
use Kaleidoscope\Factotum\Models\CustomerAddress;


class CheckoutController extends Controller
{

	use EcommerceUtils;



	// STEP 1: the user must choose the delivery address (he can add a new one)
	// STEP 2: the user must choose the invoice address (he can add a new one)
	// STEP 3: the user must choose a shipping method
	// STEP 4: the user must chosse a payment method (stripe, paypal, bank transfer, custom payment )
	// STEP 5: payment done, transactions email and thankyou page

	public function prepareCheckout( Request $request )
	{
		$view = 'factotum::ecommerce.checkout.checkout';

		if ( file_exists( resource_path('views/ecommerce/checkout/checkout.blade.php') ) ) {
			$view = 'ecommerce.checkout.checkout';
		}

		$checkoutData = $this->_prepareCheckout();

		if ( $checkoutData instanceof \Illuminate\Http\RedirectResponse ) {
			return redirect( $checkoutData->getTargetUrl() );
		}

		$viewData = array_merge( $checkoutData, [
			'metatags' => [
				'title'       => Lang::get('factotum::ecommerce_checkout.checkout_title'),
				'description' => Lang::get('factotum::ecommerce_checkout.checkout_description')
			]
		]);

		return view( $view )->with($viewData);
	}


	public function proceedCheckout( ProceedCheckout $request )
	{
		try {

			$order = $this->_proceedCheckout();

			if ( $order ) {
				return redirect( url( '/order/thank-you/' . $order->id ) );
			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko', 'message' => 'Error on creating order.' ]) : view( $this->_getServerErrorView() );

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode([
				'result' => 'ko',
				'error' => $ex->getMessage(),
				'trace' => $ex->getTrace()
			]) : view( $this->_getServerErrorView() );
		}
	}


	public function setDeliveryAddress( SetDeliveryAddress $request )
	{
		try {
			$user      = $this->_getUser();
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

			return $request->wantsJson() ? json_encode([ 'result' => 'ko' ]) : view($this->_getServerErrorView());

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
		}
	}


	public function setGuestDeliveryAddress( StoreGuestCustomerDeliveryAddress $request )
	{
		try {
			$user = $this->_getUser();
			$data = $request->all();

			if ( isset($data['email']) && $data['email'] != '' ) {
				$checkUser = User::where('email', $data['email'])->first();

				if ( $checkUser ) {
					$request->session()->put('user_id', $checkUser->id);
					$user = $checkUser;
				} else {
					$user->email = $data['email'];
					$user->save();
				}

				unset($data['email']);
			}

			$profileUpdateData = [];

			if ( isset($data['first_name']) && $data['first_name'] != '' ) {
				$profileUpdateData['first_name'] = $data['first_name'];
				unset($data['first_name']);
			}

			if ( isset($data['last_name']) && $data['last_name'] != '' ) {
				$profileUpdateData['last_name'] = $data['last_name'];
				unset($data['last_name']);
			}

			if ( isset($data['phone']) && $data['phone'] != '' ) {
				$profileUpdateData['phone'] = $data['phone'];
				unset($data['phone']);
			}

			if ( isset($data['company_name']) && $data['company_name'] != '' ) {
				$profileUpdateData['company_name'] = $data['company_name'];
				unset($data['company_name']);
			}

			if ( count($profileUpdateData) > 0 ) {
				if ( !$user->profile ) {
					$profile = new Profile;
					$profile->user_id = $user->id;
				} else {
					$profile = $user->profile;
				}
				$profile->fill($profileUpdateData);
				$profile->save();
			}

			if ( count($data) > 0 ) {
				$tmp = [
					'type'            => 'delivery',
					'customer_id'     => $user->id,
					'default_address' => true
				];
				foreach ( $data as $k => $v ) {
					$tmp[ str_replace('delivery_', '', $k) ] = $v;
				}

				$deliveryAddress = new CustomerAddress;
				$deliveryAddress->fill( $tmp );
				$deliveryAddress->save();

				if ( $deliveryAddress ) {
					$request->session()->put('delivery_address', $deliveryAddress->id );
					$request->session()->remove('invoice_address');
					$request->session()->remove('shipping');

					return $request->wantsJson() ? json_encode([ 'result' => 'ok' ]) : redirect()->back();
				}
			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko' ]) : view($this->_getServerErrorView());

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
		}
	}


	public function setInvoiceAddress( SetInvoiceAddress $request )
	{
		try {
			$user      = $this->_getUser();
			$addressId = $request->input('address_id');

			$invoiceAddress = CustomerAddress::where('customer_id', $user->id)
											->where('type', 'invoice')
											->where('id', $addressId)
											->first();

			if ( $invoiceAddress ) {
				$request->session()->put('invoice_address', $invoiceAddress->id );

				return $request->wantsJson() ? json_encode([ 'result' => 'ok' ]) : redirect()->back();
			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko' ]) : view($this->_getServerErrorView());

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
		}
	}


	public function setGuestInvoiceAddress( StoreGuestCustomerInvoiceAddress $request )
	{
		try {

			$user = $this->_getUser();

			$data = $request->all();

			if ( isset($data['same_address_as_invoice']) && $data['same_address_as_invoice'] ) {
				$deliveryAddress = CustomerAddress::where('customer_id', $user->id)
													->where('type', 'delivery')
													->orderBy('id', 'DESC')
													->first();

				$invoiceAddress = $deliveryAddress->replicate();
				$invoiceAddress->type = 'invoice';
				$invoiceAddress->save();
			} else {

				$tmp = [
					'type'            => 'invoice',
					'customer_id'     => $user->id,
					'default_address' => true
				];

				foreach ( $data as $k => $v ) {
					$tmp[ str_replace('invoice_', '', $k) ] = $v;
				}

				$invoiceAddress = new CustomerAddress;
				$invoiceAddress->fill( $tmp );
				$invoiceAddress->save();

			}

			if ( $invoiceAddress ) {
				$request->session()->put('invoice_address', $invoiceAddress->id );
				return $request->wantsJson() ? json_encode([ 'result' => 'ok' ]) : redirect()->back();
			}

			return $request->wantsJson() ? json_encode([ 'result' => 'ko' ]) : view($this->_getServerErrorView());

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
		}

	}


	public function setShipping( SetShipping $request )
	{
		try {
			$shipping = $request->input('shipping');
			$notes    = $request->input('notes', null);
			$request->session()->put('shipping', $shipping );

			$cart   = $this->_getCart( true );
			$totals = $this->_getCartTotals($cart);

			if ( $shipping ) {
				$cart->shipping = $shipping;
				$cart->save();
			}

			if ( $notes ) {
				$cart->notes = $notes;
				$cart->save();
			}

			$user = $this->_getUser();

			$result = [
				'result'        => 'ok',
				'shipping'      => true,

				'cart' => $cart,

//				'delivery_address' => $request->session()->get('delivery_address'),
//				'invoice_address'  => $request->session()->get('invoice_address'),

				'user_id' => $user->id,
				'cart_id' => $cart->id,

				'totalProducts' => $totals['totalProducts'],
				'totalPartial'  => '€ ' . number_format( $totals['totalPartial'], 2, ',', '.' ),
				'totalTaxes'    => '€ ' . number_format( $totals['totalTaxes'], 2, ',', '.' ),
				'totalShipping' => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
				'total'         => '€ ' . number_format( $totals['total'], 2, ',', '.' ),
			];

			return $request->wantsJson() ? json_encode( $result ) : redirect()->back();
		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
		}
	}

	
	public function getShipping( Request $request, $countryCode = null )
	{
		$shippingOptions = $this->_getShippingOptions( $countryCode );
		$cart            = $this->_getCart( true );
		$totals          = $this->_getCartTotals($cart);

		$view = 'factotum::ecommerce.ajax.shipping-options';

		if ( file_exists( resource_path('views/ecommerce/ajax/shipping-options.blade.php') ) ) {
			$view = 'ecommerce.ajax.shipping-options';
		}

		return $request->wantsJson() ? json_encode([
			'result'           => 'ok',
			'shipping_options' => view( $view )->with([ 'shippingOptions' => $shippingOptions, 'totalPartial' => $totals['totalPartial'] ])->render()
		]) : redirect()->back();
	}

}
