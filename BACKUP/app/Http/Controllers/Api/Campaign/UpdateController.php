<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Campaign;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreCampaign;
use Kaleidoscope\Factotum\Models\Campaign;


class UpdateController extends ApiBaseController
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
