<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignTemplate;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\CampaignTemplate;


class DeleteController extends ApiBaseController
{

	public function remove(Request $request, $id)
	{
		$campaignTemplate = CampaignTemplate::find( $id );

		if ( $campaignTemplate ) {
			$deletedRows = $campaignTemplate->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Template Campagna non trovato', 404 );
	}


	public function removeCampaignTemplates(Request $request)
	{
		$campaignTemplates = $request->input('campaign_templates');

		if ( $campaignTemplates && count($campaignTemplates) > 0 ) {
			CampaignTemplate::whereIn( 'id', $campaignTemplates )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
