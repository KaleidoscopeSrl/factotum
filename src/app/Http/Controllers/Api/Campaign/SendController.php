<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Campaign;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Kaleidoscope\Factotum\Mail\CampaignEmail as cEmail;

use Kaleidoscope\Factotum\Campaign;
use Kaleidoscope\Factotum\CampaignEmail;
use Kaleidoscope\Factotum\CampaignTemplate;

class SendController extends Controller
{

	public function send(Request $request, $campaignId)
	{
		$campaign         = Campaign::find($campaignId);
		$campaignTemplate = CampaignTemplate::find($campaign->campaign_template_id);
		$campaignEmails   = CampaignEmail::with('user')
										 ->where( 'campaign_id', $campaignId )
										->get();

		$count = 0;

		if ( !$campaign->sent_date && $campaignEmails->count() > 0 ) {

			foreach ( $campaignEmails as $ce ) {
				if ( !$ce->status ) {
					
					Mail::to( $ce->user->email )->send( new cEmail( $ce->user, $campaignTemplate, $ce ) );
					
					$count++;
				}
			}

			$campaign->sent_date = date('Y-m-d H:i:s', time());
			$campaign->save();

		}

		return response()->json( [ 'result' => 'ok', 'sent'  => $count ] );
	}

}
