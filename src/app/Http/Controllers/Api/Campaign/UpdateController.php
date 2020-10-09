<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Campaign;

use Kaleidoscope\Factotum\Http\Requests\StoreCampaign;
use Kaleidoscope\Factotum\Http\Requests\StoreCampaignFilter;
use Kaleidoscope\Factotum\Campaign;


class UpdateController extends Controller
{

	public function update(StoreCampaign $request, $id)
	{
		$data = $request->all();

		$campaign = Campaign::find( $id );
		$campaign->fill( $data );
		$campaign->save();

		return response()->json( [ 'result' => 'ok', 'campaign'  => $campaign ] );
	}

}
