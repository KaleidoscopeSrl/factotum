<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignEmail;

use Kaleidoscope\Factotum\Http\Requests\StoreCampaignEmail;
use Kaleidoscope\Factotum\Http\Requests\StoreMultipleCampaignEmail;
use Kaleidoscope\Factotum\CampaignEmail;


class CreateController extends Controller
{

	public function create( StoreCampaignEmail $request )
	{
		$data = $request->all();

		$campaign = new CampaignEmail();
		$campaign->fill( $data );
		$campaign->save();

		return response()->json( [ 'result' => 'ok', 'campaign'  => $campaign ] );
	}

	public function createMultiple( StoreMultipleCampaignEmail $request )
	{
		$campaignId = $request->input('campaign_id');
		$users      = $request->input('users');

		$count = 0;

		foreach ( $users as $userId ) {

			if ( !CampaignEmail::where( 'user_id', $userId )->where( 'campaign_id', $campaignId )->first() ) {
				$campaignEmail                = new CampaignEmail;
				$campaignEmail->user_id       = $userId;
				$campaignEmail->campaign_id   = $campaignId;
				$campaignEmail->save();

				$count++;
			}

		}

		return response()->json( [ 'result' => 'ok', 'campaign_emails'  => $count ] );
	}

}
