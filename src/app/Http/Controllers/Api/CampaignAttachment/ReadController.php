<?php

namespace App\Http\Controllers\Api\CampaignAttachment;

use Illuminate\Http\Request;

use App\CampaignAttachment;

class ReadController extends Controller
{

	public function getList(Request $request, $campaignTemplateId)
	{
		$campaignAttachments = CampaignAttachment::whereCampaignTemplateId($campaignTemplateId)->get();

		if ( $campaignAttachments->count() > 0 ) {
			return response()->json( [ 'result' => 'ok', 'campaign_attachments'  => $campaignAttachments ] );
		}

		return response()->json( [ 'result' => 'ok', 'campaign_attachments'  => [] ] );
	}

}
