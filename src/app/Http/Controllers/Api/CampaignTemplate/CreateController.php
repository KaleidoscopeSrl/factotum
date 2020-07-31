<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignTemplate;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreCampaignTemplate;
use Kaleidoscope\Factotum\CampaignTemplate;
use Kaleidoscope\Factotum\CampaignAttachment;


class CreateController extends Controller
{

	public function create( StoreCampaignTemplate $request )
	{
		$data = $request->all();

		$attachments = [];
		if ( isset($data['attachments']) ) {
			$attachments = $data['attachments'];
			unset($data['attachments']);
		}

		$campaignTemplate = new CampaignTemplate;
		$campaignTemplate->fill( $data );
		$campaignTemplate->save();

		if ( count($attachments) > 0 ) {
			foreach ( $attachments as $attachment ) {
				$ca                       = new CampaignAttachment;
				$ca->attachment_id        = $attachment['id'];
				$ca->campaign_template_id = $campaignTemplate->id;
				$ca->save();
			}
		}

		return response()->json( [ 'result' => 'ok', 'campaign_template'  => $campaignTemplate ] );
	}

	public function duplicate( Request $request, $campaignTemplateId )
	{
		$campaignTemplate = CampaignTemplate::find( $campaignTemplateId );
		$campaignTemplate = $campaignTemplate->replicate();

		$campaignTemplate->title = $campaignTemplate->title . ' clone';
		$campaignTemplate->save();

		// Clone the attachments
		$attachments = CampaignAttachment::where( 'campaign_template_id', $campaignTemplateId )->get();
		if ( $attachments->count() > 0 ) {
			foreach ( $attachments as $attachment ) {
				$ca                       = new CampaignAttachment;
				$ca->attachment_id        = $attachment['id'];
				$ca->campaign_template_id = $campaignTemplate->id;
				$ca->save();
			}
		}

		return response()->json( [ 'result' => 'ok', 'campaign_template'  => $campaignTemplate ] );
	}

}
