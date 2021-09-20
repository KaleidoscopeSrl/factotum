<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Payment;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Traits\EcommerceUtils;


class ScalaPayController extends Controller
{
	use EcommerceUtils;


	public function __construct()
	{
	}


	public function initPaymentInit(Request $request)
	{
		$result = $this->_initScalaPayPayment();

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
		$token = $request->input('orderToken');

		$result = $this->_getScalaPayTransactionId( $token );

		if ( $result && $result['result'] == 'ok' ) {
			return redirect( $result['redirect'] );
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