<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignTemplate;


use Kaleidoscope\Factotum\Http\Requests\StoreCampaignTemplate;
use Kaleidoscope\Factotum\CampaignTemplate;


class CreateController extends Controller
{

	public function create( StoreCampaignTemplate $request )
	{
		$data = $request->all();

		$campaignTemplate = new CampaignTemplate;
		$campaignTemplate->fill( $data );
		$campaignTemplate->save();

		return response()->json( [ 'result' => 'ok', 'campaign_template'  => $campaignTemplate ] );
	}

}
