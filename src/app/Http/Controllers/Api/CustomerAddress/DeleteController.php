<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CustomerAddress;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\CustomerAddress;


class DeleteController extends ApiBaseController
{

	public function remove(Request $request, $id)
	{
		$customerAddress = CustomerAddress::find( $id );

		if ( $customerAddress ) {
			$deletedRows = $customerAddress->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Customer Address not found', 404 );
	}


	public function removeCustomerAddresses(Request $request)
	{
		$customerAddresses = $request->input('customerAddresses');

		if ( $customerAddresses && count($customerAddresses) > 0 ) {
			$deletedRows = CustomerAddress::whereIn( 'id', $customerAddresses )->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ] );
			}
		}

		return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
	}

}
