<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignTemplate;

use Kaleidoscope\Factotum\Http\Requests\StoreCampaignTemplate;
use Kaleidoscope\Factotum\CampaignAttachment;
use Kaleidoscope\Factotum\CampaignTemplate;


class UpdateController extends Controller
{

	public function update(StoreCampaignTemplate $request, $id)
	{
		$data = $request->all();

		$attachments = [];
		if ( isset($data['attachments']) ) {
			$attachments = $data['attachments'];
			unset($data['attachments']);
		}

		$campaignTemplate = CampaignTemplate::find( $id );
		$campaignTemplate->fill( $data );
		$campaignTemplate->save();

		if ( count($attachments) > 0 ) {
			CampaignAttachment::where( 'campaign_template_id', $campaignTemplate->id )->delete();

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
