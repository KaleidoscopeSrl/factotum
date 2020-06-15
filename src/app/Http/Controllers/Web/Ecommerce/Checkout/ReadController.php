<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Checkout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Traits\CartUtils;


class ReadController extends Controller
{

	use CartUtils;

	// TODO: fare il checkout
	// STEP 0: preparare ordine con stato "waiting_payment"
	// STEP 1: scegliere indirizzo di consegna e di spedizione (con possibilità di aggiungerne uno nuovo e fare redirect al checkout dopo)
	// STEP 2: spedizione, corriere oppure ritiro in sede (sul salvataggio, converto il carrello in ordine con stato "da completare")
	// STEP 3: scegli metodo di pagamento (stripe, paypal, pagamento concordato con mt distribuzione)
	// STEP 4: sulla conferma di pagamento, salvare i dati di transazione e far partire l'ordine

	public function prepareCheckout( Request $request )
	{
		// 1 . Get all the customers addresses
		$user              = Auth::user();
		$deliveryAddresses = CustomerAddress::where( 'type', 'delivery' )
											->where( 'customer_id', $user->id )
											->orderBy('default_address', 'DESC')
											->get();

		$invoiceAddresses  = CustomerAddress::where( 'type', 'invoice' )
											->where( 'customer_id', $user->id )
											->orderBy('default_address', 'DESC')
											->get();

		$cart   = $this->_getCart();
		$totals = $this->_getCartTotals( $cart );


		$view = 'factotum::ecommerce.checkout';

		if ( file_exists( resource_path('views/ecommerce/checkout.blade.php') ) ) {
			$view = 'ecommerce.checkout';
		}

		$deliveryAddress = $this->_getTemporaryDeliveryAddress();
		$invoiceAddress  = $this->_getTemporaryInvoiceAddress();
		$shipping        = $this->_getTemporaryShipping();
		$shippingOptions = $this->_getShippingOptions();

		$step = 'delivery-address';

		if ( $deliveryAddress ) {
			$step = 'invoice-address';
		}

		if ( $deliveryAddress && $invoiceAddress ) {
			$step = 'shipping';
		}

		if ( $deliveryAddress && $invoiceAddress && $shipping ) {
			$step = 'payment';
		}


		// Payment methods accepted
		$paymentMethods = config('factotum.payment_methods');

		$stripe = null;
		if ( isset($paymentMethods) && in_array('stripe', $paymentMethods) && env('STRIPE_PUBLIC_KEY') && env('STRIPE_SECRET_KEY') ) {
			$stripe = [
				'publicKey' => env('STRIPE_PUBLIC_KEY')
			];
		}

		return view( $view )
				->with([
					'cart'              => $cart,

					// All the totals
					'totalProducts'     => $totals['totalProducts'],
					'totalPartial'      => $totals['totalPartial'],
					'totalTaxes'        => $totals['totalTaxes'],
					'totalShipping'     => $totals['totalShipping'],
					'total'             => $totals['total'],

					// Possible options
					'deliveryAddresses' => $deliveryAddresses,
					'invoiceAddresses'  => $invoiceAddresses,
					'shippingOptions'   => $shippingOptions,

					// Current values
					'deliveryAddress'   => $deliveryAddress,
					'invoiceAddress'    => $invoiceAddress,
					'shipping'          => $shipping,

					// Current step in checkout
					'step'              => $step,

					// Payments
					'stripe' => $stripe,

					'metatags' => [
						'title'       => Lang::get('factotum::ecommerce_checkout.checkout_title'),
						'description' => Lang::get('factotum::ecommerce_checkout.checkout_description')
					]
				]);
	}


}
