<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Cart;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Cart;


class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
		$cart = Cart::find( $id );

		if ( $cart ) {
			$deletedRows = $cart->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Cart not found', 404 );
	}


	public function removeCarts(Request $request)
	{
		$carts = $request->input('carts');

		if ( $carts && count($carts) > 0 ) {
			Cart::whereIn( 'id', $carts )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
