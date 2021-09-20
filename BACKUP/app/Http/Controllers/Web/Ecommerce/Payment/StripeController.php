<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Payment;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Traits\EcommerceUtils;


class StripeController extends Controller
{
	use EcommerceUtils;


	public function __construct()
	{
		$this->_setupStripePayment();
	}


	public function initPaymentInit(Request $request)
	{
		$result = $this->_initStripePayment();

		if ( $result ) {
			return $request->wantsJson() ? json_encode($result) : redirect()->back();
		}

		return $request->wantsJson() ? json_encode([
			'result' => 'ko',
			'error'  => 'Server Error',
		]) : view( $this->_getServerErrorView() );
	}


	public function getTransactionId( Request $request )
	{
		$stripeIntentId = $request->input( 'stripe_intent_id' );
		$transactionId  = $request->input('transaction_id');

		$result = $this->_getStripeTransactionId( $stripeIntentId, $transactionId );

		if ( $result ) {
			return $request->wantsJson() ? json_encode($result) : redirect()->back();
		}

		return $request->wantsJson() ? json_encode([
			'result' => 'ko',
			'error'  => 'Server Error',
		]) : view( $this->_getServerErrorView() );
	}


	public function paymentError( Request $request )
	{
		$view = ( file_exists( resource_path('views/errors/payment-error.blade.php') ) ? 'errors.payment-error' : 'factotum::errors.payment-error' );
		return view( $view );
	}

}