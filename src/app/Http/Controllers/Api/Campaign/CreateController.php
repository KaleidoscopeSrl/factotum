<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Campaign;

use Kaleidoscope\Factotum\Http\Requests\StoreCampaign;
use Kaleidoscope\Factotum\Campaign;

class CreateController extends Controller
{

	public function create( StoreCampaign $request )
	{
		$data = $request->all();

		$campaign = new Campaign;
		$campaign->fill( $data );
		$campaign->save();

		return response()->json( [ 'result' => 'ok', 'campaign'  => $campaign ] );
	}

}
