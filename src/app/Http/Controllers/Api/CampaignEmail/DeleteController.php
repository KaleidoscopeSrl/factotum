<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignEmail;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\CampaignEmail;


class DeleteController extends ApiBaseController
{

	public function remove(Request $request, $id)
	{
		$campaignEmail = CampaignEmail::find( $id );

		if ( $campaignEmail ) {
			$deletedRows = $campaignEmail->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Destinatario Email non trovato', 404 );
	}


	public function removeCampaignEmails(Request $request)
	{
		$campaignEmails = $request->input('campaign_emails');

		if ( $campaignEmails && count($campaignEmails) > 0 ) {
			CampaignEmail::whereIn( 'id', $campaignEmails )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
