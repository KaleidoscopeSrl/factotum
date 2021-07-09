<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignEmail;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\CampaignEmail;


class ReadController extends ApiBaseController
{

	public function getList( Request $request, $campaignId )
	{
		$campaignEmails = CampaignEmail::with([ 'user', 'campaign' ])
										->where( 'campaign_id', $campaignId)
										->get();

		return response()->json( [ 'result' => 'ok', 'campaign_emails' => $campaignEmails ]);
	}

}
