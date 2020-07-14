<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignTemplate;

use Kaleidoscope\Factotum\Http\Requests\StoreCampaignTemplate;
use Kaleidoscope\Factotum\CampaignTemplate;


class UpdateController extends Controller
{

	public function update(StoreCampaignTemplate $request, $id)
	{
		$data = $request->all();

		$campaignTemplate = CampaignTemplate::find( $id );
		$campaignTemplate->fill( $data );
		$campaignTemplate->save();

		return response()->json( [ 'result' => 'ok', 'campaign_template'  => $campaignTemplate ] );
	}

}
