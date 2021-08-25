<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\NewsletterSubscription;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\NewsletterSubscription;


class DeleteController extends ApiBaseController
{

	public function remove(Request $request, $id)
	{
		$newsletterSubscription = NewsletterSubscription::find( $id );

		if ( $newsletterSubscription ) {
			$deletedRows = $newsletterSubscription->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Iscrizione Newsletter non trovata', 404 );
	}


	public function removeNewsletterSubscriptions(Request $request)
	{
		$newsletterSubscriptions = $request->input('newsletterSubscriptions');

		if ( $newsletterSubscriptions && count($newsletterSubscriptions) > 0 ) {
			NewsletterSubscription::whereIn( 'id', $newsletterSubscriptions )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
