<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Invoice;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Invoice;


class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
		$invoice = Invoice::find( $id );

		if ( $invoice ) {
			$deletedRows = $invoice->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Invoice not found', 404 );
	}


	public function removeInvoices(Request $request)
	{
		$invoices = $request->input('invoices');

		if ( $invoices && count($invoices) > 0 ) {
			Invoice::whereIn( 'id', $invoices )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
